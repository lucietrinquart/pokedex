<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

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

});

Route::get('/item', [PokemonController::class, 'testitem']);
Route::get('/type', [PokemonController::class, 'testtype']);
Route::get('/version/{version}', [PokemonController::class, 'testversion']);