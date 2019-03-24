@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Données ouvertes</div>
        <div class="card-body">

            <h4><img src="/favicon-16x16.png" alt="tag"/> Licence</h4>
            <p>
                Les données produites sur cette plateforme sont disponibles au téléchargement sous la licence
                <a href="https://spdx.org/licenses/CC-BY-SA-4.0.html#licenseText">Creative Commons Attribution Share
                    Alike 4.0 International (CC-BY-SA-4.0)</a>.
                Cette licence s'applique à l'ensemble des données d'annotation (choix et intitulés des catégories pour
                chaque question, et bien sûr affectation détaillée des catégories en face de chaque réponse) et aussi
                à l'ensemble des textes libres de synthèse rédigés par les annotateurs.
            </p>

            <h4><img src="/favicon-16x16.png" alt="tag"/> Présentation des données</h4>
            <p>
                L'équipe qui gère ce site est très attachée à la transparence des méthodologies, des codes sources et
                des données. C'est pourquoi toutes les données produites sur cette plateforme sont disponibles au
                téléchargement sur cette page. Pour des raisons techniques, les fichiers d'export sont mis à jour
                automatiquement chaque nuit. En cours de journée, ils ne contiennent donc pas les toutes dernières
                modifications. Nous publions trois jeux de données :
            </p>
            <ul>
                <li>
                    <b>Un export complet de toutes les annotations</b>. Il s'agit d'un export brut, sans aucun
                    retraitement avec le détail des catégories affectées par chaque annotateur à chaque verbatim.
                    Cet export est le plus complet mais aussi le plus difficile à analyser. Voir les détails plus bas.
                    <a href="/download">Télécharger</a>.
                </li>
                <li>
                    <b>Un export simplifié des annotations convergentes</b>.
                    Il s'agit d'un export après retraitement. Il contient  uniquement les annotations sur lesquelles les
                    multiples annotateurs ayant lu un texte sont tombés d'accord. Cet export est plus facile à exploiter
                    que le précédent, mais moins riche. Voir les détails plus bas.
                    <a href="/downloadResults">Télécharger</a>.
                </li>
                <li>
                    <b>Un export des textes libres de synthèse</b>. Il s'agit d'un export brut, de textes qualitatifs
                    et subjectifs, rédigés par des annotateurs ayant lu de nombreuses réponses à une même question, et
                    ayant souhaité résumer les réponses qu'ils ont lu sous la forme d'un texte libre, sans contrainte.
                    Voir les détails plus bas.
                    <a href="/downloadTexts">Télécharger</a>.
                </li>
            </ul>

            <h4><img src="/favicon-16x16.png" alt="tag"/> Format de l'export complet de toutes les annotations</h4>
            <p>
                L'export est un fichier CSV (séparateur virgule, avec ligne d'entête, encodage UTF-8)
                de l'ensemble des annotations effectuées sur ce site.
                L'export ne contient pas les données brutes du grand débat (qui sont
                accessibles sur le <a href="https://granddebat.fr/pages/donnees-ouvertes">site officiel</a>,
                dans la rubrique <i>Données ouvertes</i>). Le fichier d'export contient les colonnes suivantes
            </p>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>Debat</th>
                    <td>Identifiant du débat (1 : Démocratie, 2 : Ecologie, 3 : Fiscalité, 4 : Organisation)</td>
                </tr>
                <tr>
                    <th>Contribution</th>
                    <td>Référence de la contribution (au sens du champ "reference" des fichiers JSON bruts, par exemple
                        3-56722)
                    </td>
                </tr>
                <tr>
                    <th>Question</th>
                    <td>Identifiant de la question (au sens du champ "id" des fichiers JSON bruts, par exemple 166)</td>
                </tr>
                <tr>
                    <th>Categorie</th>
                    <td>Libellé de la catégorie affectée au texte de réponse à la question</td>
                </tr>
                <tr>
                    <th>Annotateur</th>
                    <td>Identifiant de l'intervenant ayant apposé la catégorie sur la réponse</td>
                </tr>
                <tr>
                    <th>Poids</th>
                    <td>
                        Coefficient multiplicateur recommandé pour le couple (contribution, question) afin de corriger
                        les biais liés à la sur-représentation des textes fréquents dans le corpus annoté et les biais
                        liés aux réponses multiples d'un même contributeur à une même question. Pour plus de détails,
                        <a href="https://github.com/fm89/granddebat/blob/master/doc/MATH.md">voir les explications</a>.
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="alert alert-danger">
                <b>Attention !</b> Par souci de transparence, nous tenons à publier ici les données brutes de toutes les
                annotations saisies dans la plateforme. Néanmoins, nous insistons sur le fait qu'il s'agit de données
                non retraitées qu'il convient de prendre avec prudence. En particulier, elles contiennent :
                <ul>
                    <li>des tentatives de manipulation frauduleuse de la plateforme
                        (du type, "je clique toujours sur le même bouton" ou "je clique aléatoirement"),
                    </li>
                    <li>des erreurs de saisies, même par les annoteurs vertueux
                        (clic qui dérape, clic trop rapide),
                    </li>
                    <li>toutes les annotations, y compris celles qui n'ont pas (ou pas encore) été corroborées
                        par trois lectures concordantes.
                    </li>
                </ul>
                Par ailleurs, lorsqu'une personne réalise une annotation sur un texte fréquent
                (typiquement, un texte court comme "Santé et éducation"), toutes les réponses contenant le texte
                à l'identique sont automatiquement catégorisées aussi, pour gagner du temps à tous. <br><br>
                <b>Pour toutes ces raisons, il ne faut surtout pas faire d'analyse quantitative du fichier brut avant
                    d'avoir procédé à un profond nettoyage de données (détection de fraude, recherche des lectures
                    concordantes, redressement des réponses fréquentes).</b>
                Un simple décompte des libellés les plus fréquents dans le fichier
                ci-joint aboutira mécaniquement à des biais statistiques majeurs, comme la
                sur-représentation des annotations posées sur des textes courts.
                <br><br>
                Nous rendrons progressivement disponibles des propositions de scripts de retraitement.
                Vous pouvez nous contacter (voir la <a href="/faq">FAQ</a>).
            </div>

            <h4><img src="/favicon-16x16.png" alt="tag"/> Format de l'export simplifié des annotations convergentes</h4>
            <p>
                L'export est un fichier CSV (séparateur virgule, avec ligne d'entête, encodage UTF-8)
                donnant, pour chaque réponse annotée par suffisamment d'annotateurs différents, les annotations
                concordantes obtenues.
                L'export ne contient pas les données brutes du grand débat (qui sont
                accessibles sur le <a href="https://granddebat.fr/pages/donnees-ouvertes">site officiel</a>,
                dans la rubrique <i>Données ouvertes</i>). Le fichier d'export contient les colonnes suivantes
            </p>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>Debat</th>
                    <td>Identifiant du débat (1 : Démocratie, 2 : Ecologie, 3 : Fiscalité, 4 : Organisation)</td>
                </tr>
                <tr>
                    <th>Contribution</th>
                    <td>Référence de la contribution (au sens du champ "reference" des fichiers JSON bruts, par exemple
                        3-56722)
                    </td>
                </tr>
                <tr>
                    <th>Question</th>
                    <td>Identifiant de la question (au sens du champ "id" des fichiers JSON bruts, par exemple 166)</td>
                </tr>
                <tr>
                    <th>Categorie</th>
                    <td>Libellé de la catégorie affectée au texte de réponse à la question</td>
                </tr>
                <tr>
                    <th>Poids</th>
                    <td>
                        Coefficient multiplicateur recommandé pour le couple (contribution, question) afin de corriger
                        les biais liés à la sur-représentation des textes fréquents dans le corpus annoté et les biais
                        liés aux réponses multiples d'un même contributeur à une même question. Pour plus de détails,
                        <a href="https://github.com/fm89/granddebat/blob/master/doc/MATH.md">voir les explications</a>.
                    </td>
                </tr>
                </tbody>
            </table>


            <h4><img src="/favicon-16x16.png" alt="tag"/> Format de l'export des textes libres de synthèse</h4>
            <p>
                L'export est un fichier CSV (séparateur virgule, avec ligne d'entête, encodage UTF-8)
                listant les textes libres de synthèse rédigés par des annotateurs.
                Le fichier d'export contient les colonnes suivantes
            </p>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>Debat</th>
                    <td>Identifiant du débat (1 : Démocratie, 2 : Ecologie, 3 : Fiscalité, 4 : Organisation)</td>
                </tr>
                <tr>
                    <th>Question</th>
                    <td>Identifiant de la question (au sens du champ "id" des fichiers JSON bruts, par exemple 166)</td>
                </tr>
                <tr>
                    <th>Annotateur</th>
                    <td>Identifiant de l'intervenant ayant rédigé le texte de synthèse</td>
                </tr>
                <tr>
                    <th>Texte</th>
                    <td>
                        Le texte rédigé par l'annotateur pour synthétiser les réponses qu'il a lues à la question,
                        au format <a href="https://commonmark.org/help/">Markdown</a>.
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
@endsection
