@extends('layouts.visitor')

@section('jumbo')
    <div class="title mb-5">
        Les contributions <span class="high">libres</span> au grand débat
    </div>
    <p class="mb-4">
        <!-- Ordre de grandeur : 5 167 000 (7 millions en comptant les réponses à choix multiples) -->
        Plus de <b>5 millions de textes</b> ont été rédigés en réponse aux <b>questions ouvertes</b>.
    </p>
    <p class="mb-4">
        Ensemble, sur <b>grandeannotation.fr</b>, nous en avons déjà annoté <b>{{ number_format($done_count, 0, ',', ' ') }}</b>.
    </p>
    <p class="mb-4">
        Chacun a été lu et interprété plusieurs fois. &Agrave; votre tour, <b>lisez-en</b> ci-dessous.
    </p>
@endsection

@section('center')
    <div id="app">
        <book :initial-questions="{{ json_encode($questions) }}" :initial-response="{{ json_encode($response) }}" :initial-tags="{{ json_encode($tags) }}"></book>
    </div>
@endsection

@section('bottom')
    <p style="font-size: 1.25em; padding: 20px;">
        <b>Vous comprenez un texte bien mieux que n'importe quelle IA !</b>
        Vous souhaitez contribuer et nous aider à construire
        une synthèse collective, transparente et fondée sur l'intelligence humaine ?
        Il vous suffit de continuer à lire les textes en cochant les idées clefs associées.
        En 10 minutes par jour, vous faciliterez les analyses futures de chercheurs, journalistes
        ou d'autres citoyens !
    </p>
    <div class="d-flex justify-content-center align-items-center align-self-middle mt-5 mb-5" style="width: 100%">
        <a class="btn btn-soft btn-lg" href="/register">
            Créer mon compte
        </a>
    </div>
    <br>
    <br>
@endsection
