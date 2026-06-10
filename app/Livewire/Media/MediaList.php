<?php

namespace App\Livewire\Media;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MediaList extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    public $openModal = false;
    public $editMode = false;
    public $editingId = null;

    public $name;
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
        $this->name = null;
        $this->file = null;
        $this->type = null;
    }

   public function save()
    {
        $this->validate([
            'file' => 'required|file|max:51200', // 50 MB
        ]);

        $mimeType = $this->file->getMimeType();

        if (str_starts_with($mimeType, 'image/')) {
            $type = 'image';
            $directory = 'media/images';
        } elseif (str_starts_with($mimeType, 'video/')) {
            $type = 'video';
            $directory = 'media/videos';
        } else {
            $this->addError('file', 'Tipe file tidak didukung.');
            return;
        }

        $path = $this->file->store($directory, 'public');
        $storagePath = '/storage/' . $path;

        Media::create([
            'name' => $this->name ?: pathinfo(
                $this->file->getClientOriginalName(),
                PATHINFO_FILENAME
            ),
            'file' => $storagePath,
            'type' => $type,
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
                $q->where('name', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate(12);

        return view('livewire.media.list', [
            'media' => $media
        ]);
    }
}