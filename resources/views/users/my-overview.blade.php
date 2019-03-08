@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Ma synthèse
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <b>Comment ça marche ?</b>
                <br>
                Avec les bons outils, chacun peut se faire sa propre idée des contributions de ses
                concitoyens au grand débat national. C'est notre conviction.
                <ul>
                    @guest
                        <li>Connectez-vous ou créez-vous un compte.</li>
                    @endguest
                    <li>Choisissez un thème et une question qui vous intéresse particulièrement parmi la liste des
                        questions ouvertes.
                    </li>
                    <li>Lisez les réponses formulées par les contributeurs du site officiel et catégorisez-les en
                        choisissant votre grille d'analyse.
                    </li>
                    <li>Revenez sur cette page pour consulter les résultats de votre synthèse personnalisée.</li>
                </ul>
            </div>
            @if (count($ongoing) > 0)
                <h3>Questions en cours d'analyse</h3>
                <div class="text-muted">
                    Pour ne pas vous présenter des résultats trop fragiles sur le plan statistique,
                    nous n'affichons les graphiques de synthèse qu'à partir d'un nombre minimum de 300 réponses
                    lues pour une question donnée. Ce volume permet de garantir une certaine représentativité de
                    l'échantillon que vous avez classifié (au sein de l'échantillon granddebat.fr, qui n'est
                    bien sûr lui-même pas représentatif de la population française dans son ensemble).
                    D'expérience, il faut plus ou moins une heure pour classifier
                    300 réponses (cette durée varie selon la difficulté de la question traitée et la finesse de la
                    catégorisation recherchée). Si vous n'avez pas le temps de classifier 300 réponses, vous pourrez
                    consulter les synthèses communes (qui seront établies sur des milliers de réponses).
                </div>
                <br>
                <table class="table table-bordered table-sm">
                    @foreach ($ongoing as $row)
                        <tr>
                            <td>{{ $row['question']->debate->name }}</td>
                            <td><a href="/questions/{{ $row['question']->id }}/read">{{ $row['question']->text }}</a>
                            </td>
                            <td>
                                <div class="badge badge-pill badge-primary">{{ $row['count'] }}</div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            @if (count($done) > 0)
                <h3>Questions analysées</h3>
                <div class="text-muted">
                    Merci d'avoir catégorisé 300 réponses à ces questions. Puisqu'elles vous intéresse, continuez à
                    lire des réponses. Vous affinerez ainsi les graphiques ci-dessous et vous aiderez la communauté
                    à solidifier l'analyse commune. Attention, ces graphiques étant tracés à partir d'un nombre
                    relativement faible de réponses, il peut y avoir des écarts importants avec le contenu moyen du reste du
                    corpus, notamment sur les catégories les moins fréquentes. De plus, il s'agit de votre propre
                    analyse avec vos propres catégories, qui ne recouvrent pas forcément exactement celles utilisées
                    par les autres annotateurs de ce site. Seules les 15 catégories les plus fréquentes sont affichées.
                    Les quantités indiquées représentent le nombre de fois que vous avez utilisé une catégorie.
                </div>
                <br>
                @foreach ($done as $row)
                    <h5>{{ $row['question']->debate->name }}</h5>
                    <b><a href="/questions/{{ $row['question']->id }}/read">{{ $row['question']->text }}</a></b>
                    <div class="badge badge-pill badge-primary">{{ $row['count'] }}</div>
                    <canvas id="canvas{{ $row['question']->id }}"></canvas>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" defer>
        @foreach ($done as $row)
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById("{!! 'canvas' . $row['question']->id !!}").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: [@foreach (array_keys($row['stats']) as $key) "{!! $key !!}", @endforeach],
                    datasets: [{
                        label: "Nombre d'attributions de la catégorie",
                        data: [@foreach (array_values($row['stats']) as $value) "{!! $value !!}", @endforeach],
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        yAxes: [{
                            ticks: {mirror: true, padding: -10}
                        }]
                    }
                }
            });
        });
        @endforeach
    </script>
@endsection
