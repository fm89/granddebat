@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Contribution <b>{{ $proposal->reference() }}</b></div>
        <div class="card-body">
            <b>{{ $proposal->title }}</b>
            <br/><br/>
            @foreach ($responses as $response)
                <div class="alert alert-secondary">
                    <i>{{ $response->question->text }}</i>
                    <br/>
                    {{ $response->value }}
                </div>
            @endforeach
        </div>
    </div>
@endsection
