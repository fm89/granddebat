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
        </div>
    </div>
@endsection
