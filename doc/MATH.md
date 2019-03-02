# Explication de certains mécanismes mathématiques 

Ce guide explique comment sont calculés les *poids* du fichier disponible en téléchargement.
Ces poids ont deux objectifs :
* corriger la sur-représentation des avis de contributeurs ayant répondu plusieurs fois à la même question,
* corriger la sur-représentation des textes courts et fréquents dans le corpus annoté.

Le poids **P** donné dans le fichier est le produit des deux poids **P1** et **P2**.

Le poids est une quantité numérique, supérieure ou égale à 1, associée à un couple (question, contribution). Nous 
conseillons aux personnes souhaitant effectuer un traitement statistique des annotations de ce site d'accorder une
importance **P** à chaque couple (question, contribution). 

## Exemple

Prenons par exemple la question 166 et imaginons que le fichier téléchargé contiennent les annotations suivantes
* (166, Contribution 1, *Santé*, 1.0)
* (166, Contribution 2, *Education*, 2.0)
* (166, Contribution 3, *Santé*, 1.0)

Dans ce cas, l'interprétation correcte est que (1.0 + 1.0) / (1.0 + 2.0 + 1.0) = 50% des contributions mentionnent la 
santé comme politique publique. Si l'on ne tient pas compte du poids, on dirait que 2 contributions sur 3 la mentionne
(soit 66%). Ce chiffre serait faux car il ne tiendrait pas compte des corrections du poids qui sont nécessaires.

## Poids des réponses multiples

Sur le site https://granddebat.fr, il est possible de répondre plusieurs fois à chaque questionnaire, avec le même 
compte. Ainsi, une même personne peut envoyer plusieurs dizaines de fois son avis. Si nous n'utilisions pas de poids, 
l'avis de cette personne pèserait dans les statistiques finales beaucoup plus lourd.

Pour contrebalancer cet effet, nous calculons le poids **P1 = 1 / N1** où **N1** est le nombre de fois où un même 
contributeur a répondu à la même question. Si l'on répond 3 fois, chaque réponse est lue et annotée, mais chacune ne 
porte qu'un poids 1/3.

Bien sûr, il reste possible de se créer plusieurs compte sur la plateforme https://granddebat.fr pour répondre plusieurs
fois avec plusieurs identifiants différents, d'inciter ses amis à participer aussi, etc. Nous ne pouvons hélas pas 
corriger ces effets-là.

## Poids des textes fréquents

### Motivation

Sur Grande Annotation, nous avons mis en place un mécanisme automatique d'annotation des réponses dont le texte est
identique. Ainsi, lorsqu'un annotateur lit et annote le texte "*Santé et éducation*", nous copions immédiatement ses
annotations sur toutes les réponses contenant exactement le même texte, modulo la casse et les accents. Par exemple 
"SANTE et education" se retrouvera aussi annoté du même coup. Nous avons fait ce choix pour faire gagner du temps à 
tout le monde et pour ne pas s'imposer de lire plusieurs centaines de fois les mêmes textes courts faciles à 
interpréter.

Malheureusement, ce choix s'accompagne du biais suivant : une sur-représentation des textes fréquents dans le corps
annoté. Pour le comprendre, imaginons qu'à la question 166, sur les 40000 réponses,
* 20000 contiennent exactement le texte "*Aucune*"
* 1000 contiennent le texte "Santé"
* 19000 contiennent des textes tous uniques.

Imaginons ensuite que les annotateurs tirent au sort 1000 textes uniques dans ce jeu et les annote. La probabilité
qu'au moins une des réponses "*Aucune*" soit tirée est quasiment égale à 1. Donc les 20000 réponses "*Aucune*" seront
dans le corpus annoté. De même, la probabilité de tirer une des 1000 "*Santé*" est très forte. Le corpus annoté 
contiendra donc 20000 "*Aucune*", 1000 "*Santé*" et 998 autres textes uniques. On voit qu'il y a un biais car ce
corpus annoté, bien qu'obtenu en tirant au sort 1000 textes uniques différents, n'est plus représentatif du corpus
initial.

C'est pour éliminer ce biais que nous proposons d'appliquer le poids **P2**, dont la construction mathématique garantie
que le corpus annoté est représentatif du corpus initial.

### Formule générale

Le processus de tirage au sort est le suivant : à chaque fois qu'on ouvre une page d'annotation, le logiciel tire au 
sort une réponse du corpus, avec une probabilité uniforme. Bien sûr, si la réponse a déjà été annotée, on la remet 
dans le corpus et on retire à nouveau au sort. Notons 
* **N** le nombre total de réponses à la question, 
* **D** le nombre de tirages réalisés.

On considère un groupe de **G** réponses ayant le même texte. La probababilité de l'avoir pioché au bout du processus
est **1 - (1 - G / N) ^ D**. Comme **D** est très grand, on voit que cette probabilité tend très vite vers 1 pour 
les gros groupes. Le poids **P2** attribué à chaque réponse de ce groupe est l'inverse de cette probabilité. Ainsi,
les réponses d'un petit groupe, qui avait peu de chance d'être pioché, ont un plus gros poids que celles des grands 
groupes.

### Calcul du nombre de tirages

Malheureusement, nous ne stockons pas le nombre **D** de tirages réalisés qui sert au calcul de **P2**. Il faut donc
reconstituer ce nombre a posteriori. Il s'avère que cela est possible. 

Notons **Ns** le nombre de réponses dont le texte est différent de toutes les autres. Après **D** tirages aléatoires 
avec remises, en moyenne **Ds = D * Ns / N** ont été faits parmi ces réponses unitaires. Comme **Ns** et **N** sont
connus, il suffit de connaître **Ds** pour connaître **D**. 

A priori, on ne connaît pas **Ds** mais on connaît **Da**, le nombre de réponses unitaires différentes annotées.
Or, après **Ds** tirages aléatoires avec remise parmi un lot de taille **Ns**, on sait calculer l'espérance du nombre
d'objets différents obtenus, qui vaut **(1 - t ^ Ds) / (1 - t)** où **t = 1 - 1 / Ns**. 

Pour une justification, voir 
https://math.stackexchange.com/questions/72223/finding-expected-number-of-distinct-values-selected-from-a-set-of-integers

Ainsi, on retrouve **Ds** en écrivant que **Da = (1 - t ^ Ds) / (1 - t)**, où on connaît **t** et **Da**.
