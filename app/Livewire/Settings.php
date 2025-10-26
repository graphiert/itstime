<?php

namespace App\Livewire;

use Livewire\Component;

class Settings extends Component
{
  public $destination = '';
  
  public function mount()
  {
  $this->destination = auth()->user()->channel_name ?? "Destination channel has not set.";
  }

  public function render()
  {
    return view('livewire.settings')->title('Settings');
  }
}
