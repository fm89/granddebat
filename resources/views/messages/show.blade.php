@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Message <b>{{ $message->title }}</b>
        </div>
        <div class="card-body">
            {!! \GrahamCampbell\Markdown\Facades\Markdown::convertToHtml($message->content) !!}
        </div>
    </div>
@endsection
