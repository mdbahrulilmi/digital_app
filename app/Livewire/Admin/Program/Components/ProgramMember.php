<?php

namespace App\Livewire\Admin\Program\Components;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Program;
use App\Models\Journal;

class ProgramMember extends Component
{
    use WithPagination;

    public Program $program;

    public $search = '';

    public $selectedMember = null;
    public $showJournalModal = false;
    public $journalPage = 1;

    public function mount(Program $program)
    {
        $this->program = $program;
    }

        public function openJournal($memberId)
    {
        $this->selectedMember = $this->program->members()->find($memberId);
        $this->showJournalModal = true;
    }

    public function closeModal()
    {
        $this->showJournalModal = false;
        $this->selectedMember = null;
    }

    public function getMemberJournals($memberId)
    {
        return Journal::where('member_id', $memberId)
            ->where('program_id', $this->program->id)
            ->orderBy('date', 'desc')
            ->paginate(5, ['*'], 'journalPage', $this->journalPage)
            ->through(function ($journal) {
                return [
                    'title' => $journal->entry,
                    'date'  => \Carbon\Carbon::parse($journal->date)->translatedFormat('d M Y')
                ];
            });
    }

    public function loadMoreJournals()
    {
        $this->journalPage++;
    }

    public function render()
    {
        $members = $this->program
            ->members()
            ->when($this->search, function($q){

                $q->where(function($query){

                    $query
                    ->where('name','like','%'.$this->search.'%')
                    ->orWhere(
                        'email',
                        'like',
                        '%'.$this->search.'%'
                    );

                });

            })
            ->paginate(10);

        return view(
            'livewire.admin.program.components.member',
            compact('members')
        );
    }
}