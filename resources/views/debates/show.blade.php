@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Débat <i>{{ $debate->name }}</i></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Question</th>
                    <th>Score</th>
                    <th>Communauté</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($debate->questions as $question)
                    <tr>
                        @if ($question->is_free)
                            <td>
                                <a href="/questions/{{ $question->id }}">{{ $question->text }}</a>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-primary">{{ $question->myScore(\Illuminate\Support\Facades\Auth::user()) }}</span>
                            </td>
                            <td>
                                <span class="badge badge-pill badge-light">{{ $question->score() }}</span>
                            </td>
                        @else
                            <td>QCM / {{ $question->text }}</td>
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
