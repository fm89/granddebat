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
                        @if ($tag->isCustom())
                            <td><a href="/tags/{{ $tag->id }}"><i>{{ $tag->getLabel() }}</a></i></td>
                        @else
                            <td><a href="/tags/{{ $tag->id }}">{{ $tag->getLabel() }}</a></td>
                        @endif
                        <td><span class="badge badge-pill badge-secondary">{{ $counts[$tag->id] ?? 0 }}</span></td>
                        <td>
                            @can('update', $tag)
                                <a href="/tags/{{ $tag->id }}/edit"><i class="fa fa-pen"></i></a>
                                @can('inject', $tag)
                                    <a href="/tags/{{ $tag->id }}/inject" class="ml-3"><i class="fa fa-random text-warning"></i></a>
                                @endcan
                                @if ($tag->isCustom() || (($counts[$tag->id] ?? 0) == 0))
                                    <a href="/tags/{{ $tag->id }}/delete" class="ml-3"><i class="fa fa-trash text-danger"></i></a>
                                @endif
                            @else
                                <span class="badge badge-pill badge-light">Catégorie commune</span>
                            @endcan
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
