<?php

namespace App\Livewire\Admin\Member;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Member;

class MemberList extends Component
{
    use WithPagination;

    public $search = '';

    public $showProgramModal = false;
    public $selectedMember = null;
    public $memberPrograms = [];

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

    public function showPrograms($memberId)
    {
        $member = Member::with([
            'programs.schedules'
        ])->findOrFail($memberId);

        $this->selectedMember = $member;

        $this->memberPrograms = $member->programs
            ->map(function ($program) use ($member) {

                $journal = \App\Models\Journal::where('member_id', $member->id)
                    ->whereIn('program_schedule_id', $program->schedules->pluck('id'))
                    ->count();

                $totalSchedule = $program->schedules->count();

                $program->progress = $totalSchedule
                    ? round(($journal / $totalSchedule) * 100)
                    : 0;

                return $program;

            });

        $this->showProgramModal = true;
    }

    public function closeProgramModal()
    {
        $this->reset([
            'showProgramModal',
            'selectedMember',
            'memberPrograms'
        ]);
    }

    public function render()
    {
        $members = Member::withCount('programs')
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('whatsapp', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.member.list', [
            'members' => $members
        ]);
    }
}