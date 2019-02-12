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
                        <th></th>
                    @endauth
                </tr>
                </thead>
                <tbody>
                @foreach ($debate->questions()->orderBy('order')->get() as $question)
                    <tr>
                        @if ($question->is_free)
                            <td>
                                <a href="/questions/{{ $question->id }}/read">{{ $question->text }}</a>
                                @if ($question->status == 'open')
                                    <span class="badge badge-primary badge-pill">Ouvert aux annotations</span>
                                    @auth
                                        <span class="badge badge-pill badge-primary">{{ \Illuminate\Support\Facades\Auth::user()->scores['questions'][$question->id] ?? 0 }}</span>
                                    @endauth
                                @else
                                    <span class="badge badge-secondary badge-pill">En préparation</span>
                                    @auth
                                        @if (\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                                            <span class="badge badge-pill badge-primary">{{ \Illuminate\Support\Facades\Auth::user()->scores['questions'][$question->id] ?? 0 }}</span>
                                        @endif
                                    @endauth
                                @endif
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
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
