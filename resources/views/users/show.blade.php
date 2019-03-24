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
                    <th style="width: 25%">Nom d'utilisateur</th>
                    <td>{{ $user->name }} <a href="/account/edit" style="float:right;"><i class="fa fa-pen"></i> Modifier</a></td>
                </tr>
                <tr>
                    <th>Inscription</th>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Mon activité</th>
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
                        <a href="/random">C'est parti !</a>
                    </td>
                </tr>
                @if ($user->scores['quality']['volume'] ?? 0 >= 10)
                    <tr>
                        <th>Mon score de précision</th>
                        <td>
                            <b>{{ number_format(100 * $user->scores['quality']['precision'], 1, ',', ' ') }}%</b><br>
                            <span class="text-muted">
                                Le score de
                                <a href="https://fr.wikipedia.org/wiki/Pr%C3%A9cision_et_rappel">précision</a>
                                reflète la proportion des catégories que vous avez choisies qui ont
                                aussi été choisies par la communauté au terme du processus de triple lecture convergente.
                                Si votre score de précision est bas, c'est peut-être que vous avez tendance à attribuer à un texte
                                des catégories un peu trop éloignées du sens de celui-ci. Ce chiffre est mis à jour chaque nuit.
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Mon score de rappel</th>
                        <td>
                            <b>{{ number_format(100 * $user->scores['quality']['recall'], 1, ',', ' ') }}%</b><br>
                            <span class="text-muted">
                                Le score de <a href="https://fr.wikipedia.org/wiki/Pr%C3%A9cision_et_rappel">rappel</a>
                                reflète la proportion des catégories choisies par la communauté que vous aviez aussi
                                pensé à cocher. Si votre score de rappel est bas, c'est peut-être que vous avez tendance à lire trop
                                vite et à ne pas cocher toutes les catégories associées à chaque texte.
                                Ce chiffre est mis à jour chaque nuit.
                            </span>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            <br/>
            <a href="/quit">Supprimer mon compte</a>
        </div>
    </div>
@endsection
