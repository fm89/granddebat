@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">Textes libres de synthèse de la communauté</div>
        <div class="card-body">
            <div class="alert alert-info">
                Cette page recense les textes libres écrits par la communauté des annotateurs pour traduire leur
                ressenti après la lecture de centaines de réponses à certaines questions. Il ne s'agit pas
                des analyses officielles, mais bien d'analyses individuelles, produites par des personnes
                ayant utilisé ce site pour comprendre ce qui les contributeurs de
                <a href="https://granddebat.fr/">granddebat.fr</a> avaient écrit.
                Si vous aussi vous avez beaucoup lu, nous vous invitons à <a href="/texts/create">écrire un texte</a>.
            </div>
            <table class="table table-bordered table-sm">
                <tr>
                    <th>Thème</th>
                    <th>Question</th>
                    <th>Lien</th>
                    <th>Auteur</th>
                </tr>
                @foreach ($texts as $text)
                    <tr>
                        <td>{{ $text->question->debate->name }}</td>
                        <td>{{ $text->question->text }}</td>
                        <td><a href="/texts/{{ $text->id }}"><i class="fa fa-book"></i></a></td>
                        <td>{{ $text->user->name }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
