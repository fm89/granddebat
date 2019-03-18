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
            font-weight: 900;
        }

        h4 {
            font-weight: 900;
        }

        b {
            font-weight: 700;
        }

        #jumbo {
            position: relative;
            overflow: hidden;
            padding-top: 2em;
            padding-bottom: 2em;
        }

        @media only screen and (min-height: 800px) {
            #jumbo {
                padding-top: 5em;
                padding-bottom: 5em;
            }
        }

        .high {
            background-image: linear-gradient(to right, transparent 50%, #BDDCFD 50%);
            background-size: 200% 40%;
            background-repeat: repeat-x;
            background-position: -100% 100%;
        }

        #jumbo p {
            font-size: 1.50em;
        }

        #questions p {
            font-size: 1.25em;
        }

        #exemple {
            color: black;
            font-size: 1.25em;
            background-color: #eeeeee;
        }
    </style>
</head>
<body>

@include('layouts.navbar')

<section id="jumbo" class="text-center text-black">
    <div class="container py-3">
        <div style="min-height: 100%;" class="d-flex justify-content-center align-items-middle">
            <div class="d-flex justify-content-center align-items-center align-self-middle">
                <div class="content">
                    @yield('jumbo')
                </div>
            </div>
        </div>
    </div>
</section>


<section id="exemple">
    <div class="container py-5">
        <div id="app">
            @yield('center')
        </div>
    </div>
</section>


<section id="questions" class="mt-5">
    <div class="container">
        <div class="row py-5">
            @yield('bottom')
        </div>
    </div>
</section>

@include('layouts.footer')
</body>
</html>
