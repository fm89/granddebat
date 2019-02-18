@extends('layouts.app')

@section('content')
    @if ($demo)
        <div class="alert alert-info">
            <span style="font-size: 1.25em; font-weight: 800;">
                Bien joué ! Vous avez vu, c'était facile et rapide !
            </span>
            <br/>
            <span style="font-size: 1.15em;">
                Il est nécessaire de vous inscrire pour pouvoir enregistrer vos annotations et contribuer à
                l'effort collectif. Ceci permet de garantir l'honnêteté et la qualité des annotations saisies.
                Nous ne ferons rien de votre email, promis (<a href="/legal">en savoir plus</a>).
            </span>
        </div>
    @endif
    <div class="card">
        <div class="card-header">Inscription</div>

        <div class="card-body">
            @if (!$demo)
                <div class="alert alert-info">
                    Il est nécessaire de vous inscrire pour pouvoir enregistrer vos annotations et contribuer à l'effort
                    collectif. Ceci permet de garantir l'honnêteté et la qualité des annotations saisies.
                    Nous ne ferons rien de votre email, promis (<a href="/legal">en savoir plus</a>).
                    Si vous avez déjà un compte, vous pouvez <a href="/login">vous connecter</a>.
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Pseudonyme</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                               name="name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Adresse électronique</label>

                    <div class="col-md-6">
                        <input id="email" type="email"
                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                               value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <small id="emailHelp" class="form-text text-muted">
                            Votre adresse n'est utilisée que pour vous permettre de ré-initialiser votre mot de passe
                            en cas de perte. Vous ne recevrez aucun autre courriel de notre part. Vous pouvez à tout
                            moment supprimer définitivement votre compte (<a href="/legal">en savoir plus</a>).
                        </small>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Mot de passe</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                               required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmation du mot de
                        passe</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                               required>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Créer le compte
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
