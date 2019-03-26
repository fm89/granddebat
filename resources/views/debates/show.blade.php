@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">Thème <i>{{ $debate->name }}</i></div>
        <div class="card-body">
            <div class="alert alert-info">
                <p>
                    Voici les questions du thème {{ $debate->name }}. Certaines sont des questions fermées
                    (à choix multiples) et donc très faciles à analyser. Nous nous concentrons donc ici sur les
                    questions ouvertes (à texte libre) pour lesquelles la lecture est indispensable.
                </p>
                @if ($debate->status == 'open')
                    <br/>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-primary" href="/debates/{{ $debate->id }}/random">
                            <i class="fa fa-btn fa-play"></i>
                            Démarrer au hasard
                        </a>
                    </div>
                    <br/>
                @endif
            </div>
            <table class="table table-hover">
                <tbody>
                @foreach ($debate->questions()->orderBy('order')->get() as $question)
                    @if ($question->status == 'section')
                        <tr class="table-info">
                            <td>
                                <b>{{ $question->text }}</b>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @elseif ($question->is_free)
                        <tr>
                            <td>
                                <a href="/questions/{{ $question->id }}/read">{{ $question->text }}</a>
                                @if ($question->status == 'open')
                                    @auth
                                        @if ($user->scores['total'] >= $question->minimal_score)
                                            <span class="badge badge-primary badge-pill">Ouvert aux annotations</span>
                                            <span class="badge badge-pill badge-primary">{{ $user->scores['questions'][$question->id] ?? 0 }}</span>
                                        @else
                                            <span class="badge badge-secondary badge-pill">Score requis : {{ $question->minimal_score }}</span>
                                        @endif
                                    @else
                                        <span class="badge badge-primary badge-pill">Ouvert aux annotations</span>
                                    @endauth
                                @else
                                    <span class="badge badge-secondary badge-pill">En préparation</span>
                                    @auth
                                        @if ($user->role == 'admin')
                                            <span class="badge badge-pill badge-primary">{{ $user->scores['questions'][$question->id] ?? 0 }}</span>
                                        @endif
                                    @endauth
                                @endif
                            </td>
                            <td>
                                @if ($question->status == 'open')
                                    <a href="/questions/{{ $question->id }}/search">
                                        <i class="fa fa-btn fa-search"></i>
                                    </a>
                                @endif
                            </td>
                            <td>
                                @auth
                                    @if ($question->status == 'open')
                                        <div class="progress" style="width: 100px;">
                                            <div class="progress-bar bg-success" style="width: {{ $progress[$question->id] }}%" role="progressbar"></div>
                                        </div>
                                    @endif
                                    @if ($user->role == 'admin')
                                        <a href="/questions/{{ $question->id }}">
                                            <i class="fa fa-btn fa-pen"></i>
                                        </a>
                                    @endif
                                @endauth
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td>
                                <a href="/questions/{{ $question->id }}/read">
                                    {{ $question->text }}
                                </a>
                            </td>
                            <td></td>
                            <td>
                                <i class="fa fa-icon fa-chart-pie"></i>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.back_debates')
@endsection
