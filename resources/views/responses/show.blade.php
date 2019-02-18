@extends('layouts.app', ['compact' => true])

@section('content')
    <tagger :demo="false" :question="{{ $question }}"
            @if (isset($previous_question)) :previous-question="{{ $previous_question->toJSON() }}" @endif
            @if (isset($previous_response)) :initial-previous-response="{{ $previous_response->toJSON() }}" @endif
            :initial-tags="{{ json_encode($tags) }}" :initial-key="'{{ $key }}'"
            :initial-user="{{ json_encode($user == null ? null : ['role' => $user->role, 'score' => $user->scores['total']]) }}"
            :initial-response="{{ json_encode($response) }}"></tagger>
    @include('layouts.back_tags')
@endsection
