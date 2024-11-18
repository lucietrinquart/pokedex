<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'pokemon'], function (){
    Route::get('/', [PokemonController::class, 'index']); // pour l'index des Pokémon
    Route::get('/search', [PokemonController::class, 'search']); // pour la recherche
    Route::get('/{pokemon}', [PokemonController::class, 'show']); // pour afficher un Pokémon
    Route::get('/{pokemon}/varieties', [PokemonController::class, 'showVarieties']); // pour afficher les variétés
    Route::get('/{pokemon}/evolution', [PokemonController::class, 'showEvolutionPokemon']); // pour afficher les évolutions
    Route::get('/{pokemon}/sensibilite', [PokemonController::class, 'pokemonsensibilite']); // pour afficher les types
    Route::get('/{pokemon}/move', [PokemonController::class, 'showmoves']);
    Route::get('/{pokemon}/evolution2', [PokemonController::class, 'evolution2']);
    Route::get('/{pokemon}/typefaiblesse', [PokemonController::class, 'faiblesse']);
    Route::get('/{pokemon}/abilities', [PokemonController::class, 'abiliti']);

});
Route::get('/type/{typeId}/pokemon', [PokemonController::class, 'typepourpokemon']);
Route::get('/item', [PokemonController::class, 'testitem']);
Route::get('/type', [PokemonController::class, 'testtype']);
Route::get('/version/{version}', [PokemonController::class, 'testversion']);
Route::get('/evolution', [PokemonController::class, 'evolution']);
Route::get('/item', [PokemonController::class, 'item']);
Route::get('/move', [PokemonController::class, 'move']);
Route::get('/evolutiontrigger', [PokemonController::class, 'evolutiontrigger']);

Route::get('/auth/redirect', function () {
    return Socialite::driver('github')
        ->scopes(['read:user', 'public_repo'])  // Demande des permissions supplémentaires
        ->redirect();
});

Route::get('/auth/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    // Recherche l'utilisateur existant par son github_id, sinon, crée-le
    $user = User::updateOrCreate(
        ['github_id' => $githubUser->id],
        [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'github_token' => $githubUser->token,
            'github_refresh_token' => $githubUser->refreshToken,
        ]
    );

    // Authentifie l'utilisateur dans l'application
    Auth::login($user);

    // Redirige vers le tableau de bord ou une autre page
    return redirect('/dashboard');
});