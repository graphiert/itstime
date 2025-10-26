<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreTask extends Form
{
  #[Validate('required|string|min:3|max:255')]
  public $title;
  
  #[Validate('nullable|min:8')]
  public $description;
  
  #[Validate('required|date|after:yesterday')]
  public $due;
}
