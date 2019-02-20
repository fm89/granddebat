@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            &Agrave; propos des badges
        </div>
        <div class="card-body">
            Les badges pour permettent de visualiser votre progression d'une manière ludique. Ils vous sont attribués
            au fur et à mesure que vous annotez des réponses.
            @auth
                Actuellement, vous êtes <b>{{ $level[2] }}</b>
                car vous avez annoté <b>{{ $user->scores['total'] . ($user->scores['total'] > 1 ? ' textes' : ' texte') }}</b>.
                Pour continuer à progresser, <a href="/random">c'est par ici</a>.
            @else
                <a href="/register">Créez un compte</a> ou <a href="/login">connectez-vous</a> pour commencer à gravir
                les échelons.
            @endauth
            <br/><br/>
            <table class="table table-hover">
                <tbody>
                @for ($i = 0; $i < count($levels); $i++)
                    <tr>
                        <td>
                            <span class="badge badge-pill badge-{{ $levels[$i][1] }}">&nbsp;</span>
                            {{ $levels[$i][0] }}
                            @if ($i == count($levels) - 1)
                                +
                            @else
                                &rarr; {{ $levels[$i+1][0] - 1 }}
                            @endif
                        </td>
                        <td>
                            <b>{{ $levels[$i][2] }}</b>
                        </td>
                        @auth
                            <td>@if ($levels[$i][2] == $level[2]) Votre badge actuel @endif</td>
                        @endauth
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>
@endsection
