@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Contribution : &ldquo;{{ $proposal->title }}&rdquo;</div>
        <div class="card-body">
            @foreach ($responses as $response)
                <p>
                    <b>{{ $response->question->text }}</b>
                    <br/>
                    @include('responses.value', ['value' => $response->value])
                    <br/>
                </p>
            @endforeach
        </div>
    </div>
@endsection
