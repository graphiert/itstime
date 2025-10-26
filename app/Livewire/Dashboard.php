<?php

namespace App\Livewire;

use App\Livewire\Forms\StoreTask;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
  // Dashboard
  public $user;
  public $term = '';
  public $tasks;
  
  // Alert
  public $alertIsShown = false;
  public $head = '';
  public $message = '';
  
  // Sort and filter
  public $sortView = 'latest';
  public $filterStatus = 'all';
  public function filterAll() { $this->filterStatus = 'all'; }
  public function filterDone() { $this->filterStatus = 'done'; }
  public function filterOngoing() { $this->filterStatus = 'ongoing'; }
  public function filterOverdue() { $this->filterStatus = 'overdue'; }
  public function filterLate() { $this->filterStatus = 'late'; }
  public function sortLatest() { $this->sortView = 'latest'; }
  public function sortOldest() { $this->sortView = 'oldest'; }
  public function sortNearest() { $this->sortView = 'nearest'; }
  public function sortFarthest() { $this->sortView = 'farthest'; }
  
  // Form
  public StoreTask $form;
  
  public function mount()
  {
    $this->user = auth()->user();
    $this->form->due = now()->addHours(2)->format('Y-m-d\TH:i');
  }
  
  public function save()
  {
    $this->form->validate();
    $this->user->tasks()->create($this->form->all());
    
    $this->head = '"'.$this->form->title.'" created.';
    $this->message = "You will be reminded before ". Carbon::parse($this->form->due)->format('F d, Y H:i').'.';
    
    $this->filterStatus = 'all';
    $this->sortView = 'latest';
    
    $this->form->reset();
    $this->form->due = now()->addHours(2)->format('Y-m-d\TH:i');
    
    $this->alertIsShown = true;
  }
  
  public function render()
  {
    $this->tasks = $this->user->tasks()
      ->when(
        $this->term !== '',
        fn ($query) => $query->searchView($this->term)
      )
      ->sortView($this->sortView)
      ->filterStatus($this->filterStatus)
      ->get();
    return view('livewire.dashboard')->title('Dashboard');
  }
}
