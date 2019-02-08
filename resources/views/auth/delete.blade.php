@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Suppression du compte</div>
        <div class="card-body">
            <div class="alert alert-danger">
                <p>
                Vous allez supprimer votre compte. Votre nom d'affichage et votre adresse électronique seront alors
                immédiatement effacés de la base de données. Il ne sera plus possible de récupérer votre compte.
                Vos annotations apparaîtront alors sous le pseudonyme <i>Utilisateur supprimé</i>.
                </p>
                {!! Form::open(['url' => '/quit']) !!}
                <button type="submit" class="btn btn-danger">
                    <i class="fa fa-btn fa-trash"></i>
                    Supprimer définitivement mon compte
                </button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
