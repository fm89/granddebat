# Grande Annotation

## Contexte et objectifs

Dans le cadre du *grand débat national*, le gouvernement français a lancé le 22 janvier 2019 [granddebat.fr](https://granddebat.fr), 
un site internet permettant aux citoyens de s’exprimer sur quatre thèmes déclinés en près de 100 questions.
La lecture de nombreuses contributions nous a convaincus que l’intelligence artificielle seule ne parviendrait
pas à restituer fidèlement les idées, opinions et sentiments exprimés par ceux qui ont participé au débat.

Ce projet est donc celui d'une plateforme d'annotation collaborative, afin de donner les moyens à la 
société civile de créer sa propre synthèse de ces contributions, dans un processus totalement libre et ouvert.

L'idée est de pouvoir faire lire par des humains l'ensemble des textes, en y associant des libellés afin de faire
émerger les idées les plus répandues et de regrouper les réponses dont le contenu est similaire.
Il n'est en aucun cas question de juger de l'utilité, de la faisabilité ou de la valeur des idées ou 
des opinions exprimées par les contributeurs, mais uniquement d'amorcer un travail de consolidation.

Pour plus de détails sur notre approche, voir la [FAQ](https://grandeannotation.fr/faq).

## Architecture technique et technologies

* Les données sont stockées dans une base de données relationnelle [PostgreSQL 10](https://www.postgresql.org/).
* L'application côté serveur est écrite en [PHP 7.1](http://www.php.net/), avec le framework [Laravel 5.7](https://laravel.com/).
* Certaines parties de l'interface côté client utilisent le framework [Vue.JS](https://vuejs.org/) 
pour fournir une expérience d'utilisation plus fluide (notamment dans l'écran principal d'affectation de catégories).
* La gestion des dépendances PHP est effectuée grâce à l'outil [composer](https://getcomposer.org/) et 
celle des dépendances JS et CSS grâce à l'outil [yarn](https://yarnpkg.com/). Ce dernier assure aussi la compilation des ressources
côté client (JS et CSS).

## Installation d'une instance

* Clôner le dépôt de code complet.
* Créer un fichier `.env` en copiant le fichier `.env.example` et exécuter la commande `php artisan key:generate`.
* Installer les dépendances `composer install` et `yarn install` et compiler les ressources CSS et JS `yarn run prod`.
* Créer une base de données Postgres et renseigner les identifiants correspondants dans le fichier `.env`.
* Exécuter la commande `CREATE EXTENSION unaccent;` dans la base de données pour activer cette extension.
* Créer les tables du modèle de données à l'aide de la commande `php artisan migrate`.
* Télécharger et consolider les données ouvertes à l'aide du script `/data/opendata.py` à exécuter dans le dossier `/data/`.
* Importer les données consolidées pour peupler la base, par exemple à l'aide de commandes telles que
```postgresql
COPY debates (id, name) FROM './data/debates.csv' CSV DELIMITER ';' HEADER ENCODING 'UTF-8';
COPY questions (id, text, debate_id, is_free, "order", previous_id) FROM './data/questions.csv' CSV DELIMITER ';' HEADER ENCODING 'UTF-8';
COPY proposals FROM './data/proposals.csv' CSV DELIMITER ';' HEADER ENCODING 'UTF-8';
COPY responses (id, value, question_id, proposal_id) FROM './data/responses.csv' CSV DELIMITER ';' HEADER ENCODING 'UTF-8';
```
* Exécuter le code de regroupement des réponses identiques (modulo des variantes non significatives) pour éviter
aux annotateurs de faire du travail en double :
```postgresql
CREATE TABLE textgroups (
	id SERIAL,
	textvalue TEXT
);

INSERT INTO textgroups (textvalue) SELECT DISTINCT(LOWER(unaccent(responses.value))) FROM responses WHERE clean_value_group_id IS NULL;

CREATE TABLE new_responses AS 
TABLE responses
WITH NO DATA;

INSERT INTO new_responses 
SELECT responses.id, responses.value, responses.question_id, responses.proposal_id, textgroups.id
FROM responses
INNER JOIN textgroups ON lower(unaccent(responses.value)) = textgroups.textvalue
WHERE responses.clean_value_group_id IS NULL;

UPDATE new_responses SET priority = 0;

SET session_replication_role = 'replica';
DELETE FROM responses WHERE clean_value_group_id IS NULL;
INSERT INTO responses SELECT * FROM new_responses;
SET session_replication_role = 'origin';

DROP TABLE new_responses;
DROP TABLE textgroups;
```
* Activer un ou plusieurs débats et une ou plusieurs questions en passant leur paramètre `status` à `open`.
* Lancer l'application `php artisan serve`.
* Inscrire au moins un utilisateur via l'interface.
* En base de données, changer son rôle (paramètre `role`) à `admin` pour qu'il puisse créer de nouveaux tampons
 sans aucune contrainte.
