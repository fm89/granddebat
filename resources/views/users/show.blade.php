@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            Détails de mon compte
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Inscription</th>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Mon score</th>
                    <td>{{ $user->scores['total'] }} textes annotés</td>
                </tr>
                <tr>
                    <th>Mon badge</th>
                    <td>
                        <span class="badge badge-pill badge-{{ $user->badgeColor() }}" style="font-size: 14px;">
                            {{ $user->badgeText() }}
                        </span>
                        <a href="/levels">&Agrave; propos des badges</a>
                    </td>
                </tr>
                <tr>
                    <th>Prochain objectif</th>
                    <td>
                        Plus que {{ $user->todoForNextLevel() }} avant le prochain badge. Courage !
                        <a href="/responses/{{ $next_response->id }}">C'est parti !</a>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            <a href="/quit">Supprimer mon compte</a>
        </div>
    </div>
@endsection
