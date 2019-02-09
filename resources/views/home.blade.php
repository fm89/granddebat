@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info">
                <p>
                    Nous catégorisons les textes écrits dans le cadre du grand débat pour faire émerger
                    les idées les plus répandues et regrouper les réponses similaires.
                </p>
                <p>
                    Il n'est pas cas question ici de juger de l'utilité, de la faisabilité ou de la valeur
                    des idées ou des opinions exprimées.
                </p>
                <p>
                    <b>Aidez-nous en lisant des textes et en leur attribuant des catégories.</b>
                </p>
                <br/>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary" href="/responses/{{ $next_response->id }}">
                        <i class="fa fa-btn fa-play"></i>
                        Démarrer la lecture
                    </a>
                </div>
                <br/>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Intitulé du débat</th>
                    <th>Score</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($debates as $debate)
                    <tr>
                        <td>
                            <a href="/debates/{{ $debate->id }}">{{ $debate->name }}</a>
                        </td>
                        <td>
                            <span class="badge badge-pill badge-primary">{{ $my_scores[$debate->id] }}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
