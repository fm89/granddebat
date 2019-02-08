@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Les thèmes du grand débat</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Intitulé du débat</th>
                    <th>Mon score</th>
                    <th>Communauté</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($debates as $debate)
                    <tr>
                        <td>
                            <a href="/debates/{{ $debate->id }}">{{ $debate->name }}</a>
                        </td>
                        <td>
                            <span class="badge badge-pill badge-primary">{{ $my_scores[$debate->id] }}</span>
                        </td>
                        <td>
                            <span class="badge badge-pill badge-light">{{ $scores[$debate->id] }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="alert alert-info">
                <b>Quelques principes</b>
                <br/><br/>
                <ul>
                    <li>
                        Notre objectif est d'annoter les textes écrits dans le cadre du grand débat en y associant
                        des libellés afin de faire émerger les idées les plus répandues et de regrouper les réponses
                        dont le contenu est similaire.
                    </li>
                    <li>
                        L'annotation manuelle permet de bénéficier de la finesse de la lecture par un humain
                        et d'éviter de tomber dans des pièges d'interprétation par une machine : négation ou ironie par exemple.
                    </li>
                    <li>
                        Il n'est en aucun cas question ici de juger de l'utilité, de la faisabilité ou de la valeur
                        des idées ou des opinions exprimées par les contributeurs, mais uniquement d'amorcer un travail
                        de consolidation.
                    </li>
                    <li>
                        Le contenu des contributions est déjà accessible sur le
                        <a href="https://granddebat.fr/pages/donnees-ouvertes">site officiel</a>.
                        Les annotations saisies ici seront elles-aussi progressivement ouvertes
                        (sans dévoiler l'identité des personnes ayant procédé à l'annotation).
                    </li>
                    <li>
                        Le site est encore en construction. Vous pouvez soumettre vos remarques sur la page
                        <a href="https://github.com/fm89/granddebat/issues">GitHub</a>.
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
