<?php

namespace App\Livewire;

use App\Models\Resource;
use Livewire\Component;

class ResourceCategory extends Component
{

    public $resources;

    public function mount($recordId)
    {
        $this->resources = Resource::with('category')
            ->where('category_id', '=', $recordId)->select('id', 'title', 'abstract', 'authors', 'created_at', 'year_of_publication', 'cover_image', 'category_id')
            ->paginate(25);
    }

    public function render()
    {
        return view('livewire.resource-category');
    }
}
