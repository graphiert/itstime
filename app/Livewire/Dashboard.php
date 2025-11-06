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
  
  // Form
  public StoreTask $form;
  
  public function mount()
  {
    $this->head = session('head') ?? '';
    $this->message = session('message') ?? '';
    $this->alertIsShown = session('message') ? true : false;
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
