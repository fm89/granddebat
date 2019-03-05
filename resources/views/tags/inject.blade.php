@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Injection dans la catégorie <b>{{ $tag->name }}</b> pour la question <i>{{ $question->text }}</i>
        </div>
        <div class="card-body">
            <div class="alert alert-danger">
                <b>Attention !</b>
                Vous allez injecter les catégories créées par des utilisateurs dans une catégorie commune.
                Les utilisateurs concernés seront avertis par message de l'opération.
            </div>
            {!! Form::open(['url' => 'tags/' . $tag->id . '/inject']) !!}
            @foreach ($customTags as $customTag)
                <div class="form-check">
                    <input name="customTags[]" class="form-check-input" type="checkbox" value="{{ $customTag->id }}">
                    <label class="form-check-label">
                        <b>{{ $customTag->name }}</b> ({{ $customTag->user->name }})
                    </label>
                </div>
            @endforeach
            <button class="btn btn-warning" type="submit">
                <i class="fa fa-random"></i> Injecter et avertir
            </button>
            {!! Form::close() !!}
        </div>
    </div>
    @include('layouts.back_tags')
@endsection
