<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\PokemonEvolution;
use App\Models\PokemonVariety;
use App\Models\TypeInteraction;
use App\Models\Type;
use App\Models\Item;
use App\Models\Move;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    public function index()
    {
        return Pokemon::with(['defaultVariety', 'defaultVariety.sprites'])//recupère dans la table pokemon le default variéty pour ensuite cherche le sprtite dans le api/pokemon
                    ->paginate(20);//permet de faire une pagination de 20 pokemon
    }

    public function show(Pokemon $pokemon)
{
    return $pokemon->load(['defaultVariety', 'defaultVariety.sprites', 'defaultVariety.types']);//permet de récupéré le donnée sprite et type qui sont dans defaultvariety dans api/pokemon/(id du pokemon)
}

public function showVarieties(Pokemon $pokemon)
{
    return $pokemon->varieties()->with(['sprites', 'types'])->get();//recupère dans api/pokemon/(id du pokemon)/varieties les données directement
}

public function search(Request $request){//resquest contient toutes les donnée (route, utilisateur...)
    return Pokemon::search($request->input('query'))//contient ce que veux l'utilisateur
                  ->get()
                  ->load(['defaultVariety', 'defaultVariety.sprites', 'defaultVariety.types']);//la réponse
                  
}

public function testitem()
{
    return Item::with(['pokemon_evolutions_item'])
                ->paginate(20);
}

public function showEvolutionPokemon(Pokemon $pokemon)
{
    // Charger toutes les évolutions futures
    $futureEvolutions = $this->getEvolutionsRecursively($pokemon->defaultVariety->id);

    // Charger toutes les évolutions passées
    $pastEvolutions = $this->getPastEvolutionsRecursively($pokemon->defaultVariety->id);

    // Retourner directement les informations du Pokémon et toutes ses évolutions passées et futures
    return [
        'pokemon' => $pokemon->load('defaultVariety', 'defaultVariety.pokemon'), // Charger les informations du Pokémon de base
        'evolution_avant' => $pastEvolutions, // Charger les évolutions passées
        'evolution_apres' => $futureEvolutions // Charger les évolutions futures
    ];
}

// Fonction pour récupérer les évolutions futures (comme avant)
private function getEvolutionsRecursively($pokemonVarietyId)
{
    $evolutions = PokemonEvolution::where('pokemon_variety_id', $pokemonVarietyId)
        ->with('evolves_to.pokemon') // Charger les informations du Pokémon évolué
        ->get();

    foreach ($evolutions as $evolution) {
        $nextEvolutions = $this->getEvolutionsRecursively($evolution->evolves_to_id);
        $evolution->next_evolutions = $nextEvolutions;
    }

    return $evolutions;
}

// Fonction pour récupérer les évolutions passées
private function getPastEvolutionsRecursively($pokemonVarietyId)
{
    $pastEvolutions = PokemonEvolution::where('evolves_to_id', $pokemonVarietyId)
        ->with('pokemon_variety.pokemon') // Charger les informations du Pokémon précédent
        ->get();

    foreach ($pastEvolutions as $evolution) {
        $previousEvolutions = $this->getPastEvolutionsRecursively($evolution->pokemon_variety_id);
        $evolution->previous_evolutions = $previousEvolutions;
    }

    return $pastEvolutions;
}

public function pokemonsensibilite(Pokemon $pokemon)
{
    $pokemonVarietyId = $pokemon->defaultVariety->id;

    return Type::whereIn('id', function($query) use ($pokemonVarietyId) {
        $query->select('type_id')
              ->from('pokemon_variety_type')
              ->where('pokemon_variety_id', $pokemonVarietyId);
    })->get();
}

public function showmoves(Pokemon $pokemon)
{
    $pokemonVarietyId = $pokemon->defaultVariety->id;

    return Move::whereIn('id', function($query) use ($pokemonVarietyId) {
        $query->select('move_id')
              ->from('pokemon_learn_moves')
              ->where('pokemon_variety_id', $pokemonVarietyId);
    })->get();
}

public function evolution2(Pokemon $pokemon)
{
    return $pokemon->load(['defaultVariety.evolves_to_id', 'defaultVariety.pokemon_variety_id']);//permet de récupéré le donnée sprite et type qui sont dans defaultvariety dans api/pokemon/(id du pokemon)
}


public function testtype()
    {
        return Type::with([])
        ->get();
    }

}
