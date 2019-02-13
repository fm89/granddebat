@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Foire aux questions</div>
        <div class="card-body">
            <h4>Quel est l'objectif de cette plateforme ?</h4>
            <ul>
                <li>
                    Notre objectif est d'annoter les textes écrits dans le cadre du grand débat en y associant
                    des libellés afin de faire émerger les idées les plus répandues et de regrouper les réponses
                    dont le contenu est similaire.
                </li>
                <li>
                    Il n'est en aucun cas question ici de juger de l'utilité, de la faisabilité ou de la valeur
                    des idées ou des opinions exprimées par les contributeurs, mais uniquement d'amorcer un travail
                    de consolidation.
                </li>
            </ul>
            <h4>Pourquoi n'avez-vous pas recours à une analyse automatisée ?</h4>
            <ul>
                <li>
                    L'annotation manuelle permet de bénéficier de la finesse de la lecture par un humain
                    et d'éviter de tomber dans des pièges d'interprétation par une machine : négation ou ironie par
                    exemple. Ainsi, à la question <i>En qui faites-vous le plus confiance ?</i>,
                    certains répondent <i>Mon maire. Non, je plaisante. Moi-même.</i>
                </li>
                <li>
                    De plus, la lecture systématique par des humains devrait permettre de mettre en lumière une petite
                    proportion de textes de qualité, contenant une proposition réfléchie et documentée, qui pourra être
                    transmise aux administrations concernées.
                </li>
                <li>Enfin, les deux approches (manuelle et automatisée) ne sont
                    pas incompatibles mais complémentaires. Disposer d'un corpus annoté pourrait permettre d'orienter
                    les analyses automatisées dans un second temps.
                </li>
            </ul>
            <h4>Comment garantir l'honnêteté des annotations attribuées ?</h4>
            <ul>
                <li>
                    Les annotations effectuées par chaque intervenant sur ce site sont rattachées à son numéro unique.
                    Ainsi, si un intervenant se mettait à étiquetter systématiquement toute contribution avec une catégorie
                    biaisée, il serait facile a posteriori de ne pas tenir compte des annotations effectuées par cette
                    personne.
                </li>
                <li>
                    Par ailleurs, notre objectif à moyen terme est que chaque contribution au grand débat soit analysée
                    par plusieurs personnes différentes. Ainsi, le risque de mauvaise catégorisation d'une contribution
                    sera diminué d'autant. Cette approche a par exemple fait ses preuves pour la
                    <a href="http://regardscitoyens.org/interets-des-elus/">numérisation des déclarations d'intérêts des élus</a>.
                </li>
            </ul>
            <h4>Où puis-je trouver les données ?</h4>
            <ul>
                <li>
                    Le contenu complet des contributions brutes est déjà accessible sur le
                    <a href="https://granddebat.fr/pages/donnees-ouvertes">site officiel</a>,
                    dans la rubrique <i>Données ouvertes</i>. Ce sont ces données (en date du 6 février 2019)
                    qui ont été injectées dans une base
                    de données pour être annotées sur cette plateforme.
                </li>
                <li>
                    Les annotations saisies ici sont elles-aussi progressivement ouvertes
                    et téléchargeables dans la page <a href="/data">données ouvertes</a>.
                </li>
            </ul>
        </div>
    </div>
@endsection
