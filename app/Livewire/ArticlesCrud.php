<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;

class ArticlesCrud extends Component
{
    use WithPagination, WithFileUploads;

    public $title, $date, $cat, $author, $status = 'brouillon';
    public $excerpt, $content, $url;
    public $image, $imagePreview;
    public $articleId;

    public $search = '';
    public $filterCat = '';
    public $filterStatus = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    protected $rules = [
        'title'   => 'required|string|max:255',
        'date'    => 'required|date',
        'cat'     => 'required|string|max:100',
        'author'  => 'required|string|max:100',
        'status'  => 'required|in:publie,brouillon',
        'excerpt' => 'nullable|string',
        'content' => 'nullable|string',
        'url'     => 'nullable|url',
        'image'   => 'nullable|image|max:2048',
    ];

    public function resetFields()
    {
        $this->reset([
            'title', 'date', 'cat', 'author', 'status',
            'excerpt', 'content', 'url', 'image',
            'imagePreview', 'articleId'
        ]);
        $this->status = 'brouillon';
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title'   => $this->title,
            'date'    => $this->date,
            'cat'     => $this->cat,
            'author'  => $this->author,
            'status'  => $this->status,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'url'     => $this->url,
        ];
        
        // Gérer le cas de mise à jour avec une nouvelle image
        if ($this->articleId) {
            $article = Article::findOrFail($this->articleId);
            
            // Supprimer l'ancienne image si une nouvelle est téléchargée
            if ($this->image && $article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            
            // Stocker la nouvelle image ou conserver l'ancienne
            $data['image'] = $this->image ? $this->image->store('articles', 'public') : $article->image;
            
            $article->update($data);
        } else {
            // Créer un nouvel article
            $data['image'] = $this->image ? $this->image->store('articles', 'public') : null;
            Article::create($data);
        }

        $this->resetFields();
        $this->dispatch('closeModal');
        session()->flash('message', 'Article enregistré avec succès.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $this->articleId    = $article->id;
        $this->title        = $article->title;
        $this->date         = $article->date;
        $this->cat          = $article->cat;
        $this->author       = $article->author;
        $this->status       = $article->status;
        $this->excerpt      = $article->excerpt;
        $this->content      = $article->content;
        $this->url          = $article->url;
        $this->imagePreview = $article->image;
    }

    public function delete($id)
    {
        $article = Article::findOrFail($id);
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        session()->flash('message', 'Article supprimé avec succès.');
    }
    
    public function publish($id)
    {
        $article = Article::findOrFail($id);
        $article->status = 'publie';
        $article->save();
        session()->flash('message', 'Article publié avec succès.');
    }

    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterCat() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }


public function render()
{
    $query = Article::query();

    if ($this->search) {
        $query->where(function ($q) {
            $q->where('title', 'like', '%' . $this->search . '%')
              ->orWhere('excerpt', 'like', '%' . $this->search . '%')
              ->orWhere('author', 'like', '%' . $this->search . '%');
        });
    }

    if ($this->filterCat) {
        $query->where('cat', $this->filterCat);
    }

    if ($this->filterStatus) {
        $query->where('status', $this->filterStatus);
    }

    $articles = $query->latest()->paginate(5);

    // KPI
    $totalArticles = Article::count();
    $totalCategories = Article::distinct('cat')->count('cat');
    $totalPublies = Article::where('status', 'publie')->count();
    $totalBrouillons = Article::where('status', 'brouillon')->count();

    return view('livewire.articles-crud', [
        'articles' => $articles,
        'totalArticles' => $totalArticles, // <-- Ajout de cette ligne
        'totalCategories' => $totalCategories, // <-- Ajout de cette ligne
        'totalPublies' => $totalPublies, // <-- Ajout de cette ligne
        'totalBrouillons' => $totalBrouillons, // <-- Ajout de cette ligne
    ]);
}
}