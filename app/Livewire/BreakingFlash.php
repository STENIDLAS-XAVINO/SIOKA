<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FlashInfos;

class BreakingFlash extends Component
{
    public $flashInfos;

    public function mount()
    {
        // Récupérer tous les flashs publiés
        $this->flashInfos = FlashInfos::where('statut', 'publie')
            ->orderBy('date_publication', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.breaking-flash', [
            'flashInfos' => $this->flashInfos
        ]);
    }
}
