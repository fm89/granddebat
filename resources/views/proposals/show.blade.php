@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Intégralité de la contribution intitulée "<i>{{ $proposal->title }}</i>"
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                Voici l'ensemble des réponses fournies par un contributeur du site officiel
                aux questions du thème <b>{{ $debate->name }}</b>
                à {{ $proposal->city . ', le ' . $proposal->published_at->format('j') . ' ' .
                ['01' => 'janvier', '02' => 'février', '03' => 'mars'][$proposal->published_at->format('m')] }} 2019.
            </div>
            @foreach ($responses as $response)
                <p>
                    <b>{{ $response->question->text }}</b>
                    <br/>
                    @include('responses.value', ['value' => $response->value])
                    <br/>
                </p>
            @endforeach
            <br/>
            <a class="btn btn-light" href="/proposals/{{ $next_proposal->id }}" style="float: right;">
                <i class="fa fa-btn fa-step-forward"></i>
                Lire une autre au hasard
            </a>
        </div>
    </div>
    @include('layouts.back_debates')
@endsection
