# La Grande Annotation

Dans le cadre du Grand débat national, le gouvernement français a lancé le 22 janvier 2019 [granddebat.fr](https://granddebat.fr), 
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

## Architecture et technologies

* Les données sont stockées dans une base de données relationnelle [PostgreSQL 10](https://www.postgresql.org/).
* L'application côté serveur est écrite en [PHP 7.1](http://www.php.net/), avec le framework [Laravel 5.7](https://laravel.com/).
* Certaines parties de l'interface côté client utilisent le framework [Vue.JS](https://vuejs.org/) 
pour fournir une expérience d'utilisation plus fluide (notamment dans l'écran principal d'affectation de catégories).
* La gestion des dépendances PHP est effectuée grâce à l'outil [composer](https://getcomposer.org/) et 
celle des dépendances JS et CSS grâce à l'outil [yarn](https://yarnpkg.com/). Ce dernier assure aussi la compilation des ressources
côté client (JS et CSS).
