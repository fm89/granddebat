@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Foire aux questions</div>
        <div class="card-body">
            <h4>D’où vient ce projet ?</h4>
            <ul>
                <li>
					Dans le cadre du Grand débat national, le Gouvernement a lancé le 22 janvier 2019 <a href="https://granddebat.fr">granddebat.fr</a>, un site internet permettant aux citoyens de s’exprimer sur quatre thèmes déclinés en près de 100 questions.
				</li>
				<li>
					La lecture de nombreuses contributions nous a convaincus que l’intelligence artificielle seule ne parviendrait pas à restituer fidèlement les idées, opinions et sentiments exprimés par ceux qui ont participé au débat.
                </li>
				<li>
					Nous sommes aussi convaincus que les citoyens peuvent collectivement réaliser une synthèse de ce débat en adoptant une démarche transparente et ouverte.
				</li>
            </ul>
			<h4>Quel est l'objectif de cette plateforme ?</h4>
            <ul>
                <li>
					Notre objectif est d'annoter les textes écrits dans le cadre du grand débat en y associant des libellés afin de faire émerger les idées les plus répandues et de regrouper les réponses dont le contenu est similaire.
                </li>
				<li>
					Il n'est en aucun cas question de juger de l'utilité, de la faisabilité ou de la valeur des idées ou des opinions exprimées par les contributeurs, mais uniquement d'amorcer un travail de consolidation.
				</li>
			</ul>
			<h4>Qui sommes-nous ?</h4>
			<ul>
				<li>
					Nous sommes un petit groupe de citoyens bénévoles, chercheurs, datascientists, développeurs, militants du libre. Nous ne sommes associés à aucun parti politique, syndicat ou lobby dans le cadre de ce projet. Certains d’entre nous ont contribué au débat, d’autres non. Nous sommes convaincus de l’importance d’un traitement transparent des contributions par la société civile.
				</li>
                <li>
                    Nous n'avons aucun lien avec les prestataires sélectionnés par le Gouvernement pour mener l'analyse officielle des contributions de granddebat.fr.
                </li>
				<li>
					Ce projet est soutenu par les associations <a href="https://codefor.fr/">Code for France</a> et <a href="https://dataforgood.fr/">Data for Good</a>.
				</li>
			</ul>
			<h4>Pourquoi n'avez-vous pas recours à une analyse automatisée ?</h4>
            <ul>
                <li>Tout d'abord, les contributeurs de granddebat.fr n'ont pas écrit leurs réponses pour qu'elles soient lues par des machines. Nous pensons que la lecture en elle-même, par des humains, sur un thème ou des questions particulières, est riche d'enseignements.</li>
                <li>Certaines contributions, bien que porteuses de sens, risquent d'être écartées par une machine si elles ne contiennent pas les mots-clés attendus, alors qu'un humain peut comprendre à quoi elles se réfèrent.</li>
                <li>
					L'annotation manuelle permet de bénéficier de la finesse de la lecture par un humain et d'éviter de tomber dans des pièges d'interprétation par une machine : négation ou ironie par exemple. Ainsi, à la question <i>En qui faites-vous le plus confiance ?</i>, certains répondent <i>Mon maire. Non, je plaisante. Moi-même</i>.
				</li>
				<li>
					De plus, la lecture systématique par des humains devrait permettre de mettre en lumière une petite proportion de textes de qualité, contenant une proposition réfléchie et documentée, qui pourra être transmise aux administrations concernées.
				</li>
				<li>
					Enfin, les deux approches (manuelle et automatisée) ne sont pas nécessairement incompatibles.
                    Disposer d'un corpus annoté est quasiment toujours un pré-requis pour ceux qui souhaiteraient
                    entraîner des modèles dits "d'intelligence artificielle".
				</li>
			</ul>
			<h4>Mais … la tâche est pharaonique, non ?</h4>
            <ul>
                <li>
					En effet, il y a au 6 février près de 190 000 contributions individuelles au Grand débat,
                    correspondant à 1,5 million de morceaux de textes de réponses uniques.
                    Il devrait y en avoir 2,5 millions d'ici la mi-mars.
				</li>
				<li>
					D’après nos premières mesures, si 5 000 personnes consacrent 5 à 10 minutes par jour à ce projet
                    pendant 20 jours, la base entière pourrait être annotée. Tout le monde peut participer.
				</li>
				<li>
					Au pire, nous n’annoterons pas toute la base et ce travail sera tout de même très utile.
                    Une analyse de 20% de la base est déjà hautement significative puisque les contributions
                    sont choisies aléatoirement.
				</li>
				<li>
					Nous avons conçu la plateforme pour que vous puissiez annoter les contributions en attendant les
                    transports en commun ou un ami en retard sur votre téléphone,
                    depuis votre canapé sur votre ordinateur, au rythme qui vous convient.
				</li>
			</ul>
			<h4>Comment sont choisies les catégories proposées par défaut ?</h4>
            <ul>
                <li>
					Nous avons utilisé deux approches : une approche statistique, reposant sur des algorithmes de modèles thématiques développés par des chercheurs en datascience et une approche empirique consistant à lire un grand nombre de contributions jusqu’à identifier clairement les réponses les plus fréquentes.
				</li>
				<li>
					Nous avons essayé de créer des catégories objectives, exhaustives, synthétiques, en nombre suffisamment réduit pour permettre un travail de regroupement efficace. Nous espérons que ces catégories recouvrent la majorité des idées exprimées, mais vous avez la possibilité de créer des catégories supplémentaires vous-mêmes.
				</li>
			</ul>
			<h4>Comment garantir l'honnêteté des annotations attribuées ?</h4>
            <ul>
                <li>
					Les annotations effectuées par chaque intervenant sur ce site sont rattachées à son numéro unique. C’est pour cela que nous vous demandons de créer un compte. Ainsi, si un intervenant se mettait à étiqueter systématiquement toute contribution avec une catégorie biaisée, il serait facile a posteriori de ne pas tenir compte des annotations effectuées par cette personne.
				</li>
				<li>
					Par ailleurs, notre objectif à moyen terme est que chaque contribution au grand débat soit analysée par plusieurs personnes différentes. Ainsi, le risque de mauvaise catégorisation d'une contribution sera diminué d'autant. Cette approche a par exemple fait ses preuves pour la <a href="http://regardscitoyens.org/interets-des-elus/">numérisation des déclarations d'intérêts des élus</a>.
				</li>
			</ul>
			<h4>Où puis-je trouver les données ?</h4>
			<ul>
				<li>
					Le contenu complet des contributions brutes est déjà accessible sur le <a href="https://granddebat.fr/pages/donnees-ouvertes">site officiel</a>, dans la rubrique <i>Données ouvertes</i>. Ce sont ces données (en date du 6 février 2019) qui ont été injectées dans une base de données pour être annotées sur cette plateforme. Les nouvelles contributions seront importées lorsqu'elles seront disponibles sur le site officiel.
				</li>
				<li>
					Les annotations saisies ici sont elles aussi progressivement ouvertes et téléchargeables dans la page <a href="/data">données ouvertes</a>.
				</li>
				<li>
					Le code source de la plateforme est disponible sur <a href="https://github.com/fm89/granddebat">GitHub</a>. Vous pouvez y contribuer, par exemple en proposant vos idées ou des modifications (<a href="https://github.com/fm89/granddebat/issues">issues</a> et <a href="https://github.com/fm89/granddebat/pulls">pull requests</a>).
				</li>
			</ul>
			<h4>Comment nous contacter ?</h4>
			<ul>
				<li>Vous pouvez proposer vos idées pour améliorer la plateforme ou la démarche sur le répertoire <a href="https://github.com/fm89/granddebat">GitHub</a> qui héberge le code source de cette plateforme.</li>
                <li>Pour toute autre question, vous pouvez aussi écrire à notre équipe par l'adresse courriel Gmail "grandeannotation".</li>
			</ul>
        </div>
    </div>
@endsection
