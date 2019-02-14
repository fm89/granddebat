@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Résultats pour la question fermée <b>{{ $question->text }}</b>
        </div>
        <div class="card-body">
            <canvas id="canvas"></canvas>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            Retour au débat <a href="/debates/{{ $question->debate->id }}">{{ $question->debate->name }}</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" defer>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById("canvas").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels: [@foreach (array_keys($data) as $key) "{!! $key !!}", @endforeach],
                    datasets: [{
                        label: 'Proportion cochée',
                        data: [@foreach (array_values($data) as $key) "{{ $key }}", @endforeach],
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    </script>
@endsection
