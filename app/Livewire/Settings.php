<?php

namespace App\Livewire;

use Livewire\Component;

class Settings extends Component
{
  public $user;
  
  public $alertIsShown = false;
  public $head = '';
  public $message = '';
  
  public $destination = '';
  public $everyone;
  
  public $userEmail;
  public $emailConfirmation = '';
  
  public function mount()
  {
    $this->user = auth()->user();
    
    $this->everyone = $this->user->mention_everyone;
    $this->destination = $this->user->channel_name ?? "Destination channel has not set.";
    $this->userEmail = $this->user->email;
  }
  
  public function updatedEveryone()
  {
    $this->user->update(['mention_everyone' => $this->everyone]);
    $this->head = "Channel mentions updated.";
    $this->message = "Your tasks reminder will mention " . ($this->everyone ? "everyone." : "yourself.");
    $this->alertIsShown = true;
  }

  public function render()
  {
    return view('livewire.settings')->title('Settings');
  }
}
