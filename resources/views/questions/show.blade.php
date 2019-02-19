@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Catégorisation pour la question <i>{{ $question->text }}</i>
        </div>
        <div class="card-body">
            <div class="alert alert-info d-flex justify-content-center">
                <a class="btn btn-primary" href="/questions/{{ $question->id }}/read">
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
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($tags as $tag)
                    <tr>
                        <td><a href="/tags/{{ $tag->id }}">{{ $tag->name }}</a></td>
                        <td><span class="badge badge-pill badge-secondary">{{ $counts[$tag->id] ?? 0 }}</span></td>
                        <td>
                            {!! Form::open(['url' => '/tags/' . $tag->id, 'method' => 'delete']) !!}
                            @can('update', $tag)
                                <a href="/tags/{{ $tag->id }}/edit"><i class="fa fa-btn fa-pen"></i></a>
                                @if (($counts[$tag->id] ?? 0) == 0)
                                    <button class="btn btn-link ml-2" style="padding: 0;" type="submit">
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
                <th>
                    @can('create', [\App\Models\Tag::class, $question])
                        <a href="/questions/{{ $question->id }}/tags/create"><i class="fa fa-btn fa-plus"></i></a>
                    @endcan
                </th>
                </tfoot>
            </table>
            <a class="btn btn-light" href="/questions/{{ $question->id }}/search">
                <i class="fa fa-search"></i> Accéder au module de recherche
            </a>
        </div>
    </div>
    @include('layouts.back_questions')
@endsection
