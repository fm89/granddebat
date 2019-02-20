@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">Débat <i>{{ $debate->name }}</i></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Question</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($debate->questions()->orderBy('order')->get() as $question)
                    <tr>
                        @if ($question->is_free)
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
                                @auth
                                    @if (($question->status == 'open' && $user->scores['total'] >= $question->minimal_score) || ($user->role == 'admin'))
                                        <a href="/questions/{{ $question->id }}">
                                            <i class="fa fa-btn fa-pen"></i>
                                        </a>
                                    @endif
                                @endauth
                            </td>
                        @else
                            <td>
                                <a href="/questions/{{ $question->id }}/read">
                                    {{ $question->text }}
                                </a>
                            </td>
                            <td>
                                <i class="fa fa-icon fa-chart-pie"></i>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.back_debates')
@endsection
