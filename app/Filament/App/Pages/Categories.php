<?php

namespace App\Filament\App\Pages;

use App\Models\Category;
use App\Models\Resource;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Categories extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string $view = 'filament.app.pages.categories';

    public $categories;
    public $searchTerm = '';

    public $cats;

    public $isOpen = false;


    public static function getNavigationBadge(): ?string
    {
        return Category::count();
    }
    public function searchCategories()
    {
        $this->mount();
    }

    public function mount()
    {
        $this->categories = Category::when($this->searchTerm, function ($query) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        })->paginate(10)->toArray();
    }

    public function openModal($recordId)
    {
        $this->cats = Category::find($recordId)->toArray();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->category = null;
    }


}
