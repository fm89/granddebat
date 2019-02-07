@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Vérification de l'adresse électronique</div>

        <div class="card-body">
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    Un lien de vérification a été envoyé à votre adresse électronique.
                </div>
            @endif

            Avant de continuer, veuillez chercher le lien de vérification dans votre courrier électronique.
            Si vous n'avez pas reçu le lien, <a href="{{ route('verification.resend') }}">cliquez ici pour en recevoir
                un autre</a>.
        </div>
    </div>
@endsection
