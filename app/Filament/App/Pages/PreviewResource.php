<?php

namespace App\Filament\App\Pages;

use App\Models\Category;
use Filament\Pages\Page;
use App\Models\Resource;
use Illuminate\Contracts\Support\Htmlable;


class PreviewResource extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // Add this method to hide the page from the sidebar navigation
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }
    public $resource = [];

    public $isOpen = false;
    public $isClosed = true;

    public $categories;


    // The method receives $recordId from the route and uses it to load the resource
    public function mount($recordId = null)
    {
        $this->resource = Resource::findOrFail($recordId);
        $this->categories = Category::paginate(25)->toArray();

    }


    public function getCategories($catId)
    {
        $this->dispatch('category-search', $catId);
    }

    public function readmore()
    {
        $this->isOpen = true;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }


    protected static string $view = 'filament.app.pages.preview-resource';



}
