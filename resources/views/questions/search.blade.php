@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Recherche pour la question <i>{{ $question->text }}</i>
        </div>
        <div class="card-body">
            <searcher :question="{{ $question }}" :initial-tags="{{ json_encode($tags) }}"></searcher>
        </div>
    </div>
    @include('layouts.back_questions')
@endsection

