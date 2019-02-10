@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Débat <i>{{ $debate->name }}</i></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Question</th>
                    @auth
                        <th>Score</th>
                    @endauth
                    <th>Communauté</th>
                    @auth
                        <th></th>
                    @endauth
                </tr>
                </thead>
                <tbody>
                @foreach ($debate->questions as $question)
                    <tr>
                        @if ($question->is_free)
                            <td>
                                <a href="/questions/{{ $question->id }}/read">{{ $question->text }}</a>
                            </td>
                            @auth
                                <td>
                                    <span class="badge badge-pill badge-primary">{{ $question->myScore(\Illuminate\Support\Facades\Auth::user()) }}</span>
                                </td>
                            @endauth
                            <td>
                                <span class="badge badge-pill badge-light">{{ $question->score() }}</span>
                            </td>
                            @auth
                                <td>
                                    <a href="/questions/{{ $question->id }}">
                                        <i class="fa fa-btn fa-pen"></i>
                                    </a>
                                </td>
                            @endauth
                        @else
                            <td>QCM / {{ $question->text }}</td>
                            @auth
                                <td></td>
                            @endauth
                            <td></td>
                            @auth
                                <td></td>
                            @endauth
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
