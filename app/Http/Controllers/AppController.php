<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article; // <-- importer le modèle Article


class AppController extends Controller
{
    public function index()
    {
        // Récupérer les articles marqués "à la une"
        $une = Article::where('status', 'publie')
                    ->where('is_une', true)
                    ->orderBy('updated_at', 'desc') // <-- trie par date la plus récente
                    ->take(5)
                    ->get();

        // Actus classiques (hors à la une si tu veux)
        $actus = Article::where('status', 'publie')
                        ->orderBy('date', 'desc')
                        ->take(8)
                        ->get();

        // Catégories uniques
        $categories = Article::distinct('cat')->pluck('cat');

        return view('index', compact('une', 'actus', 'categories'));
    }


    public function show($id)
    {
        // Recherche l'article par son ID au lieu de son slug
        $article = Article::where('id', $id)
                        ->where('status', 'publie')
                        ->firstOrFail();

        return view('article.show', compact('article'));
    }

    public function gouvernance()
    {
        return view('gouvernance');
    }
    
    public function economie()
    {
        return view('economie');
    }

    public function social()
    {
        return view('social');
    }

    public function sport_culture()
    {
        return view('sport-culture');
    }

    public function jeunes_femmes()
    {
        return view('jeunes-femmes');
    }

    public function equipe()
    {
        return view('equipe');
    }


    // Partie pour dashboard
    public function articles()
    {
        return view('dashboard-sidebar-component.articles');
    }

    public function flash_infos()
    {
        return view('dashboard-sidebar-component.flash_infos');
    }

    // Utilisateurs
    public function utilisateurs()
    {
        return view('dashboard-sidebar-component.utilisateurs');
    }

    public function derniere_video()
    {
        return view('dashboard-sidebar-component.derniere_video');
    }
}
