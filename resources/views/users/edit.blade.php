@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Modification de mon compte
        </div>
        <div class="card-body">
            {!! Form::open(['url' => 'account']) !!}
            <div class="form-group">
                <label for="name" class="control-label">Pseudonyme</label>
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                       name="name" value="{{ old('name', $user->name) }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
                <div class="text-muted mt-3">
                    Votre pseudonyme est notamment affiché en marge des textes libres de synthèse que vous pouvez
                    rédiger une fois que vous avez lu {{ \App\Policies\TextPolicy::MIN_SCORE_PER_QUESTION }} réponses
                    à une même question. Vous êtes libres d'y renseigner votre vrai nom ou non.
                </div>
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="fa fa-btn fa-save"></i> Enregistrer ces modifications
            </button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
