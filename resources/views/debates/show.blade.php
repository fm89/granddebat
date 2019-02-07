@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Débat <i>{{ $debate->name }}</i></div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th>Question</th>
                    <th>Score</th>
                    <th>Communauté</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($debate->questions as $question)
                    <tr>
                        <td>@if (!$question->is_free) QCM @endif</td>
                        <td><a href="/questions/{{ $question->id }}">{{ $question->text }}</a></td>
                        <td>
                            <span class="badge badge-pill badge-primary">{{ $question->myScore(\Illuminate\Support\Facades\Auth::user()) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-pill badge-light">{{ $question->score() }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
