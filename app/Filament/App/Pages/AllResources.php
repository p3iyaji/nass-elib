<?php

namespace App\Filament\App\Pages;

use Filament\Pages\Page;
use App\Models\Resource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;


class AllResources extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static string $view = 'filament.app.pages.all-resources';

    public $search = '';

    protected static function getNavigationExtraAttributes(): array
    {
        return [
            'class' => 'text-indigo-500', // Set your desired color class
        ];
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public function getRecords()
    {
        return Resource::when($this->search, function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('abstract', 'like', '%' . $this->search . '%')
                ->orWhere('authors', 'like', '%' . $this->search . '%')
                ->orWhere('tags', 'like', '%' . $this->search . '%')
                ->orWhereHas('category', function (Builder $q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
        })->paginate(9);
    }



}
