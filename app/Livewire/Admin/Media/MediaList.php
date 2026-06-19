<?php

namespace App\Livewire\Admin\Media;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Traits\MediaHandler;


class MediaList extends Component
{
    use WithPagination, WithFileUploads, MediaHandler;

    public $search = '';

    public $openModal = false;
    public $editMode = false;
    public $editingId = null;

    public $title;
    public $file;
    public $type;

    public function create()
    {
        $this->resetForm();
        $this->openModal = true;
        $this->editMode = false;
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->title = null;
        $this->file = null;
        $this->type = null;
    }

   public function save()
    {
        $this->validate([
            'file' => 'required|file|max:51200',
        ]);

        $imageValue = $this->uploadImageAsWebp($this->file);

        Media::create([
            'title' => $this->title ?: \Illuminate\Support\Str::random(10),
            'file' => $imageValue,
            'type' => 'image',
            'size' => $this->file->getSize(),
        ]);

        session()->flash('message', 'Media berhasil diupload');

        $this->openModal = false;
        $this->resetForm();
    }

    public function delete($id)
    {
        $media = Media::findOrFail($id);

        $file = str_replace('/storage/', '', $media->file);

        if ($file && Storage::disk('public')->exists($file)) {
            $res = Storage::disk('public')->delete($file);
        }

        $media->delete();

        session()->flash('message', 'Media berhasil dihapus');
    }

    public function render()
    {
        $media = Media::query()
            ->when($this->search, fn($q) =>
                $q->where('title', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(12);

        return view('livewire.admin.media.list', [
            'media' => $media
        ]);
    }
}