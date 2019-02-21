@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                <p>
                    La consultation du Grand débat national est articulée autour de quatre thèmes officiels.
                    Chaque thème est sous-divisé en 10 à 30 questions. Certaines sont des questions fermées
                    (à choix multiples) et donc très faciles à analyser. Nous nous concentrons donc ici sur les
                    questions ouvertes (à texte libre) pour lesquelles la lecture est indispensable.
                </p>
                <p>
                    Vous pouvez naviguer ici par thème puis par question, ou vous laisser porter au hasard.
                    Certains thèmes ou questions ne sont pas encore ouverts à l'annotation car le travail
                    de préparation des catégories par défaut est encore en cours. N'hésitez pas à revenir
                    régulièrement.
                </p>
                <br/>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary" href="/random">
                        <i class="fa fa-btn fa-play"></i>
                        Démarrer au hasard
                    </a>
                </div>
                <br/>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Intitulé du thème</th>
                    <th>&Eacute;tape</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($debates as $debate)
                    <tr>
                        <td>
                            <a href="/debates/{{ $debate->id }}">{{ $debate->name }}</a>
                        </td>
                        <td>
                            @if ($debate->status == 'open')
                                <span class="badge badge-pill badge-primary">Ouvert aux annotations</span>
                                @auth
                                    <span class="badge badge-pill badge-primary">{{ \Illuminate\Support\Facades\Auth::user()->scores['debates'][$debate->id] }}</span>
                                @endauth
                            @else
                                <span class="badge badge-pill badge-secondary">En préparation</span>
                                @auth
                                    @if (\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                        <span class="badge badge-pill badge-primary">{{ \Illuminate\Support\Facades\Auth::user()->scores['debates'][$debate->id] }}</span>
                                    @endif
                                @endauth
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
