@extends('layouts.visitor')

@section('jumbo')
    <div class="title mb-5">
        Donnons du <span class="high">sens</span> au <span class="high">grand débat</span>
    </div>
    <p class="mb-4">
        Plus de <b>160 000 personnes</b> ont rédigé des réponses aux questions de <b>granddebat.fr</b>
    </p>
    <p class="mb-4">
        Mais <b>aucune technologie</b> n'est aujourd'hui capable de <b>comprendre leur sens</b>.
    </p>
    <p class="mb-4">
        Rejoignez {{ number_format($users_count, 0, ',', ' ') }} humains pour <b>nous aider à le faire</b>
        en les lisant !
    </p>

    <br><br>
    @auth
        <a class="btn btn-soft btn-lg mb-3" href="/random">
            Reprendre l'annotation au hasard
        </a>
    @else
        <a class="btn btn-soft btn-lg mb-3" href="/book">
            Lire et annoter des contributions
        </a>
    @endauth
@endsection

@section('center')
    <div class="row">
        <div class="col-lg-8 offset-lg-2 align-self-center" style="text-align: center">
                <span style="font-size: 24px; font-weight: 600; color: black;">
                    En quoi l'IA est-elle insuffisante pour comprendre les réponses
                    aux questions du grand débat ?
                </span>
        </div>
    </div>
    <br>
    <br>
    <sample :asample="{{ json_encode($sample) }}"></sample>
    <div class="d-flex justify-content-center align-items-center align-self-middle mt-5">
        <a class="btn btn-light btn-lg" href="/ai-limits">
            Découvrir 3 autres difficultés pour l'IA
        </a>
    </div>
@endsection

@section('bottom')
    <div class="col-lg-6 mb-5">
        <div class="px-4">
            <h4><img src="/favicon-16x16.png" alt="tag"/> Quel est notre but ?</h4>
            <p>
                Nous souhaitons que les contributions au grand débat puissent être lues et comprises.
                Ici, vous pouvez lire ces textes, classés par thème et par question,
                et les annoter pour en révéler le sens.
            </p>
            <p>
                Nous voulons construire une synthèse collective, transparente et fondée sur
                l'intelligence humaine.
            </p>
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        <div class="px-4">
            <h4><img src="/favicon-16x16.png" alt="tag"/> Qui sommes-nous ?</h4>
            <p>
                Nous sommes des citoyens indépendants et bénévoles, chercheurs, data-scientists, développeurs,
                militant pour l'ouverture des données et des codes publics. Retrouvez-nous sur
                <a href="https://twitter.com/GAnnotation">@GAnnotation</a>.
            </p>
            <p>
                Ce projet est soutenu par les collectifs <a href="https://codefor.fr/">Code&nbsp;for&nbsp;France</a>
                et <a href="https://dataforgood.fr/">Data&nbsp;for&nbsp;Good</a>.
            </p>
        </div>
    </div>
@endsection
