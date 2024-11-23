<?php

namespace App\Livewire;

use App\Models\Resource;
use Livewire\Component;

class Preview extends Component
{
    public $resource;
    public function mount($recordId)
    {
        $this->resource = Resource::findOrFail($recordId);
    }

    public function render()
    {
        return view('livewire.preview');
    }
}
