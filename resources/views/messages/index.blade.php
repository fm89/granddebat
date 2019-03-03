@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Boîte de réception
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <td>
                            <a href="/messages/{{ $message->id }}">
                                @if ($message->read)
                                    {{ $message->title }}
                                @else
                                    <b>{{ $message->title }}</b>
                                @endif
                            </a>
                        </td>
                        <td>{{ $message->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
