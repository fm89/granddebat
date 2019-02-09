@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="/debates/{{ $debate->id }}">{{ $debate->name }}</a> /
            Contribution &ldquo;{{ $proposal->title }}&rdquo;
        </div>
        <div class="card-body">
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
                Suivante
            </a>
        </div>
    </div>
@endsection
