<?php

namespace App\Livewire\Admin\LandingPage;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\LandingPage;

class LandingPageList extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $listeners = [
        'refreshList' => '$refresh',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->dispatch('openLandingPageModal', 'create');
    }

    public function edit($id)
    {
        $this->dispatch('openLandingPageModal', 'edit', $id);
    }

    public function delete($id)
    {
        LandingPage::findOrFail($id)->delete();
        session()->flash('message', 'Halaman berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.landing-page.list', [
            'pages' => LandingPage::query()
            ->whereNull('program_id')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10, ['*'], 'landing_pages'),

        'program_pages' => LandingPage::query()
            ->whereNotNull('program_id')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('title', 'like', "%{$this->search}%")
                        ->orWhere('slug', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10, ['*'], 'program_pages'),
        ]);
    }
}