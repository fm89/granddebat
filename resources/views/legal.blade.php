@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Mentions légales</div>
        <div class="card-body">
            <p>
                GrandDebat.ovh est un site non commercial non professionnel édité par une personne physique. Il a pour
                but de permettre l'annotation collective et manuelle, par des humains,
                des milliers de contributions au Grand Débat National initié
                sur le site officiel <a href="https://granddebat.fr">granddebat.fr</a>.
            </p>
            <h3>Hébergement</h3>
            <p>
                Ce site est hébergé par OVH, SAS au capital de 10 069 020 €, RCS Lille Métropole 424 761 419 00045, dont
                le siège social est sis 2 rue Kellermann, 59100 Roubaix, France.
            </p>
            <h3>Cookies</h3>
            <p>
                Ce site n'utilise aucun cookie lié à de la mesure d'audience, de la publicité ou des réseaux sociaux.
                Les seuls cookies déposés dans votre navigateurs sont ceux indispensables au fonctionnement du site et
                liés à l'authentification et à la gestion de votre session.
            </p>
            <h3>Données personnelles</h3>
            <p>
                Lors de votre inscription, vous saisissez un nom d'affichage librement et une adresse électronique.
                Celle-ci est validée par un premier courriel puis n'est utilisée que pour vous permettre de ré-initialiser
                votre mot de passe en cas de perte. Vous ne recevrez aucun autre courriel de notre part. Vous pouvez
                à tout moment supprimer définitivement votre compte. Votre nom d'affichage et votre adresse électronique
                sont alors immédiatement effacés de la base de données.
                Vos annotations apparaîtront alors sous le pseudonyme "<i>Utilisateur supprimé</i>".
            </p>
        </div>
    </div>
@endsection
