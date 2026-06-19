<?php

namespace App\Livewire\Admin\Member;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;

class MemberList extends Component
{
    use WithPagination;

    public $search = '';

    // Reset pagination ketika melakukan pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function deleteMember($id)
    {
        $member = Member::find($id);
        if ($member) {
            $member->delete();
            session()->flash('message', 'Member berhasil dihapus.');
        }
    }

    public function render()
    {
        // Mengambil data member dengan filter pencarian dan pagination
        $members = Member::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('whatsapp', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.member.list', [
            'members' => $members
        ]);
    }
}