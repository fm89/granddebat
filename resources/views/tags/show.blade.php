@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Exemples de réponses annotées avec la catégorie <i>{{ $tag->name }}</i>
        </div>
        <div class="card-body">
            @foreach ($responses as $response)
                <blockquote>
                    <p class="quotation">
                        @include('responses.value', ['value' => $response->value])
                    </p>
                    <footer>
                        <a href="/proposals/{{ $response->proposal_id }}">contribution</a>
                    </footer>
                </blockquote>
            @endforeach
        </div>
    </div>
    @include('layouts.back_tags')
@endsection
