<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GDA</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 48px;
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
                Grand Débat Annotations
            </div>
            <p style="font-size: 24px">
                Plateforme d'annotation collaborative citoyenne des contributions au grand débat
            </p>
            <p style="font-size: 24px">
                Déjà <b>{{ $actions_count }} annotations</b> déposées par <b>{{ $users_count }} bénévoles</b>
            </p>
            <br/>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary" href="/responses/{{ $next_response->id }}">
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
