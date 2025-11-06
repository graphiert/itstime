<?php

namespace App\Livewire;

use App\Livewire\Forms\StoreTask;
use App\Models\Task;
use Livewire\Component;
use Flux;

class ViewTask extends Component
{
  // Alert
  public $alertIsShown = false;
  public $head = '';
  public $message = '';
  
  // Form
  public $task;
  public StoreTask $form;
  
  public function mount(Task $task)
  {
    $this->authorize('view', $task);
    $this->task = $task;
    
    $this->form->title = $task->title;
    $this->form->description = $task->description;
    $this->form->due = $task->due->format('Y-m-d\TH:i');
  }
  
  public function update()
  {
    $this->form->validate();
    $this->head = 'Task detail has been updated.';
    $this->message = 'You have been updated this task details.';
    $this->task->update($this->form->only('title', 'description'));
    $this->alertIsShown = true;
  }
  
  public function done()
  {
    $this->head = 'This task has been done.';
    $this->message = 'You have been marked this task done.';
    $this->task->update(['done' => now()]);
    Flux::modal('mark-done')->close();
    $this->alertIsShown = true;
  }
  
  public function delete()
  {
    $title = $this->task->title;
    $this->task->delete();
    session()->flash('head', '"'.$title.'" deleted.');
    session()->flash('message', 'This task has been deleted.');
    $this->redirectRoute('dashboard', navigate: true);
  }
  
  public function render()
  {
    return view('livewire.view-task')->title($this->task->title."'s detail");
  }
}
