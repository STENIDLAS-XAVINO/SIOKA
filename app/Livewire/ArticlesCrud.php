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
        
        if ($this->articleId) {
            $article = Article::findOrFail($this->articleId);
            if ($this->image && $article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $this->image ? $this->image->store('articles', 'public') : $article->image;
            $article->update($data);
        } else {
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

    // ---------------------------
    // Gestion "À la une"
    // ---------------------------
    public function toggleUne($id)
    {
        $article = Article::findOrFail($id);

        if ($article->is_une) {
            // Retirer de la une
            $article->is_une = false;
            $article->position_une = null;
        } else {
            // Ajouter à la une à la dernière position
            $lastPosition = Article::where('is_une', true)->max('position_une') ?? 0;
            $article->is_une = true;
            $article->position_une = $lastPosition + 1;
        }

        $article->save();
        $this->dispatch('refreshComponent'); 
        session()->flash('message', 'À la une mis à jour.');
    }

    // ---------------------------
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
        $totalUne = Article::where('is_une', true)->count(); // <-- nombre des articles à la une

        return view('livewire.articles-crud', [
            'articles' => $articles,
            'totalArticles' => $totalArticles,
            'totalCategories' => $totalCategories,
            'totalPublies' => $totalPublies,
            'totalBrouillons' => $totalBrouillons,
            'totalUne' => $totalUne,
        ]);
    }
}
