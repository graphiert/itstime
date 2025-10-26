<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;
use Carbon\Carbon;

class ViewTask extends Component
{
  public StoreTask $form;
  public $task;
  public $formattedDue;
  
  public function mount(Task $task)
  {
    $this->task = $task;
    $this->formattedDue = Carbon::parse($task->due)->format('F d, Y H:i');
  }
  
  public function render()
  {
    return view('livewire.view-task')->title($this->task->title."'s detail");
  }
}
