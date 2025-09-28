<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Article;

class DerniersArticles extends Component
{
    public $categories;
    public $selectedCategory = 'toutes';

    public function mount()
    {
        // Récupère toutes les catégories pour les boutons de filtre
        $this->categories = Article::distinct('cat')->pluck('cat');
    }

    public function render()
    {
        // On récupère la base de la requête
        $query = Article::where('status', 'publie')
                        ->orderBy('date', 'desc');

        // On applique la condition de filtre si une catégorie est sélectionnée
        if ($this->selectedCategory !== 'toutes') {
            $query->where('cat', $this->selectedCategory);
        }

        // On exécute la requête pour récupérer les articles
        $articles = $query->take(8)->get();
        
        return view('livewire.derniers-articles', [
            'articles' => $articles,
        ]);
    }

    public function setCategory($category)
    {
        // Met à jour la propriété de la catégorie sélectionnée
        $this->selectedCategory = $category;
    }
}