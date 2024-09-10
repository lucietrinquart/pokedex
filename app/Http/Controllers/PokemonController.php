<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
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
}