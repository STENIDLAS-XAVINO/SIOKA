<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FlashInfos;

class FlashInfosCrud extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    public $flashId, $contenu, $date_publication, $statut = 'brouillon', $categorie;

    protected $rules = [
        'contenu' => 'required|min:5',
        'date_publication' => 'required|date',
        'statut' => 'required|in:publie,brouillon',
        'categorie' => 'nullable|string|max:50',
    ];

    // Réinitialiser le formulaire
    public function resetFields()
    {
        $this->reset(['flashId', 'contenu', 'date_publication', 'statut', 'categorie']);
        $this->statut = 'brouillon';
    }

    public function save()
    {
        $this->validate();

        FlashInfos::updateOrCreate(
            ['id' => $this->flashId],
            [
                'contenu' => $this->contenu,
                'date_publication' => $this->date_publication,
                'statut' => $this->statut,
                'categorie' => $this->categorie,
            ]
        );

        $this->dispatch('closeModal'); // fermer modal
        $this->resetFields();
        session()->flash('success', 'Flash Info enregistré avec succès ✅');
    }

    public function edit($id)
    {
        $f = FlashInfos::findOrFail($id);
        $this->flashId = $f->id;
        $this->contenu = $f->contenu;
        $this->date_publication = $f->date_publication;
        $this->statut = $f->statut;
        $this->categorie = $f->categorie;
    }

    public function delete($id)
    {
        FlashInfos::findOrFail($id)->delete();
        session()->flash('success', 'Flash Info supprimé ✅');
    }

    public function publish($id)
    {
        $f = FlashInfos::findOrFail($id);
        $f->statut = 'publie';
        $f->save();
        session()->flash('success', 'Flash Info publié ✅');
    }

    public function render()
    {
        $query = FlashInfos::query();

        if ($this->search) {
            $query->where('contenu', 'like', "%{$this->search}%");
        }

        if ($this->filterStatus) {
            $query->where('statut', $this->filterStatus);
        }

        $flashs = $query->orderBy('date_publication', 'desc')->paginate(5);

        return view('livewire.flash-infos-crud', [
            'flashs' => $flashs,
            'totalFlashs' => FlashInfos::count(),
            'totalPublies' => FlashInfos::where('statut', 'publie')->count(),
            'totalBrouillons' => FlashInfos::where('statut', 'brouillon')->count(),
        ]);
    }
}
