<?php

namespace App\Livewire;

use Livewire\Component;

class Settings extends Component
{
  public $userEmail;
  public $destination = '';
  public $emailConfirmation = '';
  
  public function mount()
  {
    $this->destination = auth()->user()->channel_name ?? "Destination channel has not set.";
    $this->userEmail = auth()->user()->email;
  }

  public function render()
  {
    return view('livewire.settings')->title('Settings');
  }
}
