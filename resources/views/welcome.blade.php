<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Grande Annotation</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 40px;
        }

        h4 {
            font-weight: 800 !important;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        #jumbo {
            position: relative;
            overflow: hidden;
            background-color: #BDDCFD;
            color: #0951A0;
        }

        @media only screen and (min-height: 800px) {
            #jumbo {
                padding-top: 5em;
                padding-bottom: 5em;
            }
        }

        #jumbo p {
            font-size: 1.50em;
        }

        #questions {
            background-color: #F8FAFC;
        }

        #questions p {
            font-size: 1.25em;
        }

        #exemple {
            background-color: #888;
        }
    </style>
</head>
<body>

@include('layouts.navbar')

<section id="jumbo" class="text-center text-black">
    <div class="container py-5">
        <div style="min-height: 100%;" class="d-flex justify-content-center align-items-middle">
            <div class="d-flex justify-content-center align-items-center align-self-middle">
                <div class="content">
                    <div class="title m-b-md" style="font-weight: 900;">
                        Grande Annotation
                    </div>
                    <p>
                        Plateforme d'annotation collaborative citoyenne des contributions au grand débat
                    </p>
                    <p>
                        Déjà <b>{{ number_format($actions_count, 2, ',', ' ') }} actions</b> réalisées par <b>{{ number_format($users_count, 2, ',', ' ') }} humains</b>
                    </p>
                    <p>
                        Lisons et catégorisons les textes écrits dans le cadre du grand débat pour faire émerger les idées les plus répandues et regrouper les réponses similaires.

                        Donnons du sens au débat !
                    </p>
                    <br/>
                    @auth
                        <a class="btn btn-primary" href="/random">
                            <i class="fa fa-btn fa-play"></i>
                            Reprendre au hasard
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<section id="questions">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="px-4 py-5">
                    <h4><img src="/favicon-16x16.png" alt="tag"/> Pourquoi ?</h4>
                    <p>Parce que la société civile peut elle aussi réaliser une synthèse de ce débat, en adoptant une démarche collaborative et transparente.</p>
                    <p>Nous pensons que l'intelligence artificielle seule ne vaut pas la lecture humaine.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="px-4 py-5">
                    <h4><img src="/favicon-16x16.png" alt="tag"/> Qui sommes-nous ?</h4>
                    <p>Des citoyens indépendants et bénévoles, chercheurs, datascientists, développeurs, militant pour l'ouverture des données et des codes publics.</p>
                    <p>Ce projet est soutenu par l'association <a href="https://codefor.fr/">Code for France</a>.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="px-4 py-5">
                    <h4><img src="/favicon-16x16.png" alt="tag"/> Comment ?</h4>
                    <p>Lisez des réponses formulées par d'autres aux questions de
                        <a href="https://granddebat.fr">granddebat.fr</a> et annotez-les.</p>
                    <p>En 10 minutes par jour, vous faciliterez les analyses futures.</p>
                    <p>Testez juste en dessous, c'est facile&nbsp;!</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="exemple">
    <div class="container py-5">
        <div id="app">
            <p style="font-size: 1.25em; color: #fff;">Voici un exemple de question posée sur le site officiel, et
                d'une réponse saisie par un contributeur. Cliquez sur la ou les catégories correspondant le plus à
                cette contribution, puis validez. Ou cliquez sur la croix grise en l'absence de réponse.</p>
            <br/>
            <tagger :demo="true" :question="{{ $question }}"
                    :initial-tags="{{ json_encode($tags) }}" :initial-key="'{{ $key }}'"
                    :initial-user="{{ json_encode($user == null ? null : ['role' => $user->role, 'scores' => $user->scores]) }}"
                    :initial-response="{{ json_encode($response) }}"></tagger>
        </div>
    </div>
</section>

@include('layouts.footer')
</body>
</html>
