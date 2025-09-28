<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Models\DerniereVideo;

class DerniereVideoCrud extends Component
{
    use WithPagination;

    #[Url(as: 'q', history: true)]
    public string $search = '';

    public ?DerniereVideo $video = null;

    #[Rule('required|string|max:255')]
    public ?string $title = '';

    #[Rule('required|string|max:255')]
    public ?string $youtube_id = '';

    #[Rule('boolean')]
    public bool $is_published = false;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $query = DerniereVideo::query()
            ->when($this->search, fn ($q) => $q->where('title', 'like', "%{$this->search}%"));

        $videos = $query->orderBy('created_at', 'desc')->paginate(8);

        return view('livewire.derniere-video-crud', compact('videos'));
    }

    public function create()
    {
        $this->reset(['video', 'title', 'youtube_id', 'is_published']);
        $this->resetValidation();
        $this->dispatch('open-modal', name: 'video-form');
    }

    public function edit(int $videoId)
    {
        $this->video = DerniereVideo::findOrFail($videoId);
        $this->title = $this->video->title;
        $this->youtube_id = $this->video->youtube_id;
        $this->is_published = $this->video->is_published;
        $this->dispatch('open-modal', name: 'video-form');
    }

    public function save()
    {
        $this->validate();

        DerniereVideo::updateOrCreate(
            ['id' => optional($this->video)->id],
            [
                'title' => $this->title,
                'youtube_id' => $this->youtube_id,
                'is_published' => $this->is_published,
            ]
        );

        session()->flash('success', $this->video ? 'Vidéo mise à jour.' : 'Nouvelle vidéo ajoutée.');
        $this->dispatch('close-modal', name: 'video-form');
        $this->reset(['video', 'title', 'youtube_id', 'is_published']);
    }

    #[On('delete-video')]
    public function delete(int $videoId)
    {
        DerniereVideo::findOrFail($videoId)->delete();
        session()->flash('success', 'Vidéo supprimée.');
    }

    public function togglePublish(int $videoId)
    {
        $video = DerniereVideo::findOrFail($videoId);
        $video->is_published = !$video->is_published;
        $video->save();
        session()->flash('success', $video->is_published ? 'Vidéo publiée.' : 'Vidéo mise en brouillon.');
    }
}