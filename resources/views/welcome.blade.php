<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GDA</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 40px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div style="min-height: 100%;" class="d-flex justify-content-center align-items-middle">
    <div class="d-flex justify-content-center align-items-center align-self-middle">
        <div class="content">
            <div class="title m-b-md">
                Grand Débat &middot; Annotations
            </div>
            <p style="font-size: 22px">
                Plateforme d'annotation collaborative citoyenne des contributions au grand débat
            </p>
            <p style="font-size: 22px">
                Déjà <b>{{ $actions_count }} annotations</b> déposées par <b>{{ $users_count }} bénévoles</b>
            </p>
            <p style="font-size: 22px">
                Donnons du sens au débat !
            </p>
            <br/>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary" href="/questions/{{ $question->id }}/read">
                    <i class="fa fa-btn fa-play"></i>
                    Commencer la lecture
                </a>
            </div>
            <br/>
            <br/>
            <br/>
            <div class="links">
                <a href="/faq">FAQ</a>
                <a href="/legal">Mentions légales</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
