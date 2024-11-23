<?php

namespace App\Filament\App\Pages;

use App\Models\Category;
use App\Models\Resource;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Books extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public $resources;
    public $recordId;
    public $categories;
    public $isOpen = false;
    public $res;

    public function resourceCategories($recordId)
    {
        $this->resources = Resource::with('category')->where('category_id', $recordId)->paginate(12)->toArray();
    }

    public function mount($recordId = null)
    {
        $this->resources = Resource::where('category_id', $recordId)->with('category')
            ->select('title', 'category_id', 'id', 'abstract', 'authors', 'cover_image', 'year_of_publication')
            ->paginate(12)->toArray();
        $this->categories = Category::paginate(25)->toArray();
    }

    public function openModal($recordId)
    {
        $this->res = Resource::find($recordId);
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->res = null;
    }

    protected static string $view = 'filament.app.pages.books';
}
