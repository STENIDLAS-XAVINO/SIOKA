<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DerniereVideo;

class DerniereVideoPublic extends Component
{
    public $video = null;

    public function mount()
    {
        // Récupère la dernière vidéo publiée, triée par date de création descendante.
        $this->video = DerniereVideo::where('is_published', true)
                                  ->orderBy('created_at', 'desc')
                                  ->first();
    }

    public function render()
    {
        return view('livewire.derniere-video-public');
    }
}