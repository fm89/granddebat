@extends('layouts.visitor')

@section('jumbo')
    <div class="title mb-5">
        Les <span class="high">limites</span> de l'intelligence artificielle
    </div>
    <p class="mb-4">
        En 2019, même les <b>meilleurs assistants vocaux</b> ne répondent qu'à des <b>commandes basiques</b>.
    </p>
    <p class="mb-4">
        L'IA peut <b>compter des mots</b> et les regrouper par thème, mais <b>ne comprend pas ce qu'elle lit</b>.
    </p>
    <p class="mb-4">
        Sous-entendus, ironie, négations, découvrez ci-dessous quelques difficultés typiques.
    </p>
@endsection

@section('center')
    <div id="app">
        <samples :samples="{{ json_encode($samples) }}"></samples>
    </div>
@endsection

@section('bottom')
    <p style="font-size: 1.25em; padding: 20px;">
        <b>Vous comprenez un texte bien mieux que n'importe quelle IA !</b>
        Venez donc lire vous-même les contributions de vos concitoyens au grand débat.
        Promis, vous en apprendrez bien plus qu'en lisant des synthèses artificielles
        (qui ne sont que des décomptes des thématiques les plus fréquentes).
        Il y a plein d'idées, d'émotions et de perles à découvrir.
        Ensemble, nous construisons une synthèse collective, transparente et fondée sur
        l'intelligence humaine.
    </p>
    <div class="d-flex justify-content-center align-items-center align-self-middle mt-5 mb-5" style="width: 100%">
        <a class="btn btn-soft btn-lg" href="/book">
            Lire et annoter des réponses
        </a>
    </div>
    <br>
    <br>
@endsection
