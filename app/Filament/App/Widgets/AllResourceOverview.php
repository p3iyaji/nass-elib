<?php

namespace App\Filament\App\Widgets;

use App\Models\Resource;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;
use Livewire\WithPagination;

class AllResourceOverview extends Widget
{
    use WithPagination;

    use InteractsWithPageFilters;

    protected static ?int $sort = 3;

    protected static string $view = 'filament.app.widgets.all-resource-overview';
    //protected int | string | array $columnSpan = 'full';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];


    public $resources;
    public $searchTerm;

    public function search()
    {
        $this->resetPage();

        return $this->resources();
    }

    public function resources()
    {
       return Resource::when($this->searchTerm, function ($query) {
           $query->where('title', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
               ->orWhere('abstract', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
               ->orWhere('authors', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
               ->orWhere('tags', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
               ->orWhereHas('category', function ($q) {
                   $q->where('name', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%');
               });
       })->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }

    public function sanitizeSearchTerm($term)
    {
        return htmlspecialchars(trim($term), ENT_QUOTES, 'UTF-8');
    }
}
