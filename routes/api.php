<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\PokemonFavoriteController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\OAuthController;



Route::prefix('auth')->group(function () {
    Route::get('/redirect', [OAuthController::class, 'redirect']);
    Route::get('/callback', [OAuthController::class, 'callback']);
    Route::middleware('auth:sanctum')->post('/logout', [OAuthController::class, 'logout']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
      return $request->user();
    });
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
        Route::get('/{pokemon}/version/{version}', [PokemonController::class, 'version']);
    
    });
    Route::get('/type/{typeId}/pokemon', [PokemonController::class, 'typepourpokemon']);
    Route::get('/item', [PokemonController::class, 'testitem']);
    Route::get('/type', [PokemonController::class, 'testtype']);
    Route::get('/version/{version}', [PokemonController::class, 'testversion']);
    Route::get('/version', [PokemonController::class, 'touteversion']);
    Route::get('/evolution', [PokemonController::class, 'evolution']);
    Route::get('/item', [PokemonController::class, 'item']);
    Route::get('/move', [PokemonController::class, 'move']);
    Route::get('/evolutiontrigger', [PokemonController::class, 'evolutiontrigger']);
});

//route pour les favoris
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/pokemon/{pokemonId}/add', [PokemonController::class, 'addPokemonToUser']);
    Route::get('/pokemonscompagnons', [PokemonController::class, 'getUserPokemons']);
    Route::delete('/pokemon/{pokemonId}', [PokemonController::class, 'removePokemonFromUser']);
});