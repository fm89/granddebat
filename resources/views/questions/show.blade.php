@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Catégorisation pour la question <i>{{ $question->text }}</i>
        </div>
        <div class="card-body">
            <div class="alert alert-info d-flex justify-content-center">
                <a class="btn btn-primary" href="/responses/{{ $next_response->id }}">
                    <i class="fa fa-btn fa-play"></i>
                    Démarrer la lecture
                </a>
            </div>
            <br/>
            <br/>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Attributions</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->name }}</td>
                        <td><a href="/tags/{{ $tag->id }}">{{ $counts[$tag->id] ?? 0 }}</a></td>
                        <td>
                            {!! Form::open(['url' => '/tags/' . $tag->id, 'method' => 'delete']) !!}
                            @can('update', $tag)
                                <a href="/tags/{{ $tag->id }}/edit"><i class="fa fa-btn fa-pen"></i></a>
                                @if (($counts[$tag->id] ?? 0) == 0)
                                    <button class="btn btn-link" type="submit">
                                        <i class="fa fa-btn fa-trash text-danger"></i>
                                    </button>
                                @endif
                            @else
                                <span class="badge badge-pill badge-light">Catégorie commune</span>
                            @endcan
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <th></th>
                <th></th>
                <th><a href="/questions/{{ $question->id }}/tags/create"><i
                                class="fa fa-btn fa-plus"></i></a></th>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            Retour au débat <a href="/debates/{{ $question->debate->id }}">{{ $question->debate->name }}</a>
        </div>
    </div>
@endsection
