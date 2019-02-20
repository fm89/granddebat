@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Données ouvertes</div>
        <div class="card-body">
            <h4>Licence</h4>
            <p>
                Les données d'annotation collective établies dans cette plateforme sont disponibles au téléchargement
                sous la licence <a href="https://spdx.org/licenses/CC-BY-SA-4.0.html#licenseText">Creative Commons Attribution Share Alike 4.0 International (CC-BY-SA-4.0)</a>.
            </p>
            <h4>Format</h4>
            <p>
                Le format n'est pas encore définitivement figé. L'export est un fichier CSV
                (séparateur virgule, avec ligne d'entête, encodage UTF-8)
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
                    <td>Référence de la contribution (au sens du champ "reference" des fichiers JSON bruts, par exemple 3-56722)</td>
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
                    <th>Annoteur</th>
                    <td>Identifiant de l'intervenant ayant apposé la catégorie sur la réponse</td>
                </tr>
                </tbody>
            </table>
            <div class="alert alert-danger">
                <b>Attention !</b> Par souci de transparence, nous tenons à publier ici les données brutes de toutes les
                annotations saisies dans la plateforme. Néanmoins, nous insistons sur le fait qu'il s'agit de données
                non retraitées qu'il convient de prendre avec prudence. En particulier, elles contiennent :
                <ul>
                    <li>des tentatives de manipulation frauduleuse de la plateforme
                        (du type, "je clique toujours sur le même bouton" ou "je clique aléatoirement"),</li>
                    <li>des erreurs de saisies, même par les annoteurs vertueux
                        (clic qui dérape, clic trop rapide),</li>
                    <li>toutes les annotations, y compris celles qui n'ont pas (ou pas encore) été corroborées
                        par trois lectures concordantes.</li>
                </ul>
                Par ailleurs, lorsqu'une personne réalise une annotation sur un texte fréquent
                (typiquement, un texte court comme "Santé et éducation", toutes les réponses contenant le texte
                à l'identique sont automatiquement catégorisées aussi, pour gagner du temps). <br><br>
                <b>Pour toutes ces raisons, il ne faut surtout pas faire d'analyse quantitative du fichier brut avant
                d'avoir procédé à un profond nettoyage de données (détection de fraude, recherche des lectures
                    concordantes, redressement des réponses fréquentes).</b><br><br>
                Nous rendrons progressivement disponibles de propositions de scripts de retraitement.
                Vous pouvez nous contacter (voir la <a href="/faq">FAQ</a>).
            </div>
            <h4>Téléchargement</h4>
            <p>
                Le fichier d'export est mis à jour automatiquement chaque nuit. Il n'est pas mis à jour en cours de
                journée et ne contient donc jamais les annotations les plus récentes.
            </p>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary" href="/download">
                    <i class="fa fa-btn fa-table"></i>
                    Télécharger l'export CSV
                </a>
            </div>
        </div>
    </div>
@endsection
