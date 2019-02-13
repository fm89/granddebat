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
                Le format n'est pas encore définitivement figé. L'export est un fichier CSV de l'ensemble des
                annotations effectuées sur ce site. L'export ne contient pas les données brutes du grand débat (qui sont
                accessibles sur le <a href="https://granddebat.fr/pages/donnees-ouvertes">site officiel</a>,
                dans la rubrique <i>Données ouvertes</i>). Le fichier d'export contient les colonnes suivantes
            </p>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>Debat</th>
                    <td>Entier identifiant le numéro du débat (1 : Démocratie, 2 : Ecologie, 3 : Fiscalité, 4 : Organisation)</td>
                </tr>
                <tr>
                    <th>Contribution</th>
                    <td>Entier identifiant la référence de la contribution (au sens du champ "reference" des fichiers JSON bruts)</td>
                </tr>
                <tr>
                    <th>Question</th>
                    <td>Entier identifiant le numéro de la question (au sens du champ "id" des fichiers JSON bruts)</td>
                </tr>
                <tr>
                    <th>Categorie</th>
                    <td>Libellé de la catégorie affectée au texte de réponse à la question</td>
                </tr>
                <tr>
                    <th>Annoteur</th>
                    <td>Entier identifiant l'intervenant ayant apposé la catégorie sur la réponse</td>
                </tr>
                </tbody>
            </table>
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
