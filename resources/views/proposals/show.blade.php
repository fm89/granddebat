@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Contribution <i>{{ $proposal->title }}</i>;
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
    @include('layouts.back_debates')
@endsection
