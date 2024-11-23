<?php

namespace App\Filament\App\Pages;

use App\Models\Resource;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ReadingList extends Page
{
    use withPagination;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static string $view = 'filament.app.pages.reading-list';

    public $member, $resources;

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    use WithPagination;

    public $isOpen = false;

    public $res;

    public $categories = [];

    public $searchTerm = '';

    public $catRes;

    protected $listeners = ['openModal', 'closeModal', 'resourceCategories'];

    public function resourceCategories($recordId)
    {
        $this->resetPage();
        $this->catRes = $recordId;
        $this->resources = $this->getResources();
    }

    public function searchBooks()
    {
        $this->resetPage();
        $this->resources = $this->getResources();
    }

    public static function getNavigationBadge(): ?string
    {
        return Resource::whereHas('members', function ($query) {
            $query->where('user_id', filament::auth()->user()->id);
        })->count();
    }

    public function getCategories($recordId)
    {
        $this->resetPage();
        $this->catRes = $recordId;
        $this->resources = $this->getResources();
    }

    public function mount()
    {
        $this->member = filament::auth()->user()->id;
        $this->resources = Resource::whereHas('members', function ($query) {
            $query->where('user_id', '=', $this->member);
        })->with('category')->paginate('10')->toArray();
        return $this->resources;
    }

    public function sanitizeSearchTerm($term)
    {
        return htmlspecialchars(trim($term), ENT_QUOTES, 'UTF-8');
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

    public function detachMember($recordId)
    {
        $resource = Resource::find($recordId);
        $member = filament::auth()->user()->id;

        $alreadyExists = $resource->members()->where('user_id', $member)->exists();
        if ($alreadyExists) {
            $detachMem = $resource->members()->detach($member);
            if ($detachMem) {
                Notification::make()
                    ->title('Resource successfully removed from your reading list')
                    ->success()
                    ->send();
            }

        }
        $this->mount();

    }

}
