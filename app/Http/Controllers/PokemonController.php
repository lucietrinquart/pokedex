<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\PokemonEvolution;
use App\Models\PokemonVariety;
use App\Models\TypeInteraction;
use App\Models\GameVersion;
use App\Models\Type;
use App\Models\Item;
use App\Models\Move;
use App\Models\EvolutionTrigger;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;


class PokemonController extends Controller
{
    public function index()
    {
        return Pokemon::with(['defaultVariety', 'defaultVariety.sprites', 'defaultVariety.types'])//recupère dans la table pokemon le default variéty pour ensuite cherche le sprtite dans le api/pokemon
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

    return [
        'pokemon' => $pokemon->load('defaultVariety', 'defaultVariety.pokemon'), 
        'evolution_avant' => $pastEvolutions, 
        'evolution_apres' => $futureEvolutions 
    ];
}

private function getEvolutionsRecursively($pokemonVarietyId)
{
    $evolutions = PokemonEvolution::where('pokemon_variety_id', $pokemonVarietyId)
        ->with('evolves_to.pokemon', 'evolves_to.sprites') // Charger les informations du Pokémon évolué
        ->get();

    foreach ($evolutions as $evolution) {
        $nextEvolutions = $this->getEvolutionsRecursively($evolution->evolves_to_id);
        $evolution->next_evolutions = $nextEvolutions;
    }

    return $evolutions;
}

private function getPastEvolutionsRecursively($pokemonVarietyId)
{
    $pastEvolutions = PokemonEvolution::where('evolves_to_id', $pokemonVarietyId)
        ->with('pokemon_variety.pokemon', 'pokemon_variety.sprites') // Charger les informations du Pokémon précédent
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

public function abiliti(Pokemon $pokemon)
{
    return $pokemon->load(['defaultVariety.abilities']);
}


public function testtype()
    {
        return Type::with([])
        ->get();
    }

    public function evolution()
    {
        return PokemonEvolution::with([])
        ->get();
    }

    
    public function item()
    {
        return Item::with([])
        ->get();
    }

    public function move()
    {
        return Move::with([])
        ->get();
    }
    public function evolutiontrigger()
    {
        return EvolutionTrigger::with([])
        ->get();
    }

    public function testversion(GameVersion $version)
    {
        return $version->load(['pokemon_learn_move.pokeon_variety']);

    }

    public function version(Pokemon $pokemon, $versionId)
    {
        // Récupérer l'ID de la variété par défaut du Pokémon
        $pokemonVarietyId = $pokemon->defaultVariety->id;

        // Récupérer toutes les attaques pour ce Pokémon dans la version spécifique
        $moves = Move::whereIn('id', function($query) use ($pokemonVarietyId, $versionId) {
            $query->select('move_id')
                  ->from('pokemon_learn_moves')
                  ->where('pokemon_variety_id', $pokemonVarietyId)
                  ->where('game_version_id', $versionId);
        })
        ->with(['move_damage_class']) // Si vous voulez inclure les informations de classe de dégâts
        ->get()
        ->map(function($move) use ($pokemonVarietyId, $versionId) {
            // Récupérer les détails spécifiques d'apprentissage pour cette attaque
            $learnDetails = \App\Models\PokemonLearnMove::where([
                'pokemon_variety_id' => $pokemonVarietyId,
                'move_id' => $move->id,
                'game_version_id' => $versionId
            ])
            ->with('move_learn_methods')
            ->first();

            // Ajouter les détails d'apprentissage à l'attaque
            return [
                'move' => $move,
                'learn_method' => $learnDetails->move_learn_methods,
                'level' => $learnDetails->level
            ];
        });

        return response()->json([
            'pokemon' => $pokemon->only(['id', 'name']),
            'version' => GameVersion::find($versionId)->only(['id', 'generic_name', 'generation']),
            'moves' => $moves
        ]);
    }

    public function faiblesse(Pokemon $pokemon): JsonResponse
{
    $pokemon->load(['defaultVariety.types']);
    $types = $pokemon->defaultVariety->types;

    $faible = [];
    $resiste = [];
    $immunities = [];

    foreach ($types as $type) {
        $interactions = $type->testtypeinteractionBy()->with('typeInteractionState')->get();

        foreach ($interactions as $interaction) {
            $typeInteractionState = $interaction->typeInteractionState;

            if (!$typeInteractionState) {
                continue; 
            }

            $multiplier = $typeInteractionState->multiplier;
            $typeName = $interaction->testtypeinteractionTo->name;

            if ($multiplier > 1) {
                $faible[$typeName] = ($faible[$typeName] ?? 1) * $multiplier;
            } elseif ($multiplier < 1 && $multiplier > 0) {
                $resiste[$typeName] = ($resiste[$typeName] ?? 1) * $multiplier;
            } elseif ($multiplier == 0) {
                $immunities[] = $typeName;
            }
        }
    }

    return response()->json([
        'pokemon' => $pokemon->name,
        'types' => $types->pluck('name'), 
        'faible' => $faible,
        'resiste' => $resiste,
        'immunities' => $immunities
    ]);
}

// public function typepourpokemon($typeId)
//     {
//         // return $pokemon->load(['defaultVariety', 'defaultVariety.types']);

//     $faible = [];
//     $resiste = [];
//     $immunities = [];

//     foreach ($types as $type) {
//         $interactions = $type->testtypeinteractionBy()->with('typeInteractionState')->get();

//         foreach ($interactions as $interaction) {
//             $typeInteractionState = $interaction->typeInteractionState;

//             if (!$typeInteractionState) {
//                 continue; 
//             }

//             $multiplier = $typeInteractionState->multiplier;
//             $typeName = $interaction->testtypeinteractionTo->name;

//             if ($multiplier > 1) {
//                 $faible[$typeName] = ($faible[$typeName] ?? 1) * $multiplier;
//             } elseif ($multiplier < 1 && $multiplier > 0) {
//                 $resiste[$typeName] = ($resiste[$typeName] ?? 1) * $multiplier;
//             } elseif ($multiplier == 0) {
//                 $immunities[] = $typeName;
//             }
//         }
//     }

//     return response()->json([
//         'pokemon' => $pokemon->name,
//         'types' => $types->pluck('name'), 
//         'faible' => $faible,
//         'resiste' => $resiste,
//         'immunities' => $immunities
//     ]);
// }

public function typepourpokemon($typeId)
    {
        $pokemons = Pokemon::whereHas('defaultVariety.types', function($query) use ($typeId) {
            $query->where('types.id', $typeId);
        })
        ->with(['defaultVariety.sprites', 'defaultVariety.types'])
        ->get();

        return response()->json($pokemons);
    }


} 


