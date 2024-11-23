<?php

namespace App\Filament\App\Pages;

use App\Models\Category;
use App\Models\Resource;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Panel\Concerns\HasNotifications;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ViewResource extends Page
{

    use HasNotifications;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.app.pages.view-resource';

    protected static ?string $navigationLabel = 'All Resources';

    public static function getNavigationBadge(): ?string
    {
        return Resource::count();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }
    use WithPagination;

    public $isOpen = false;
    public $res;
    public $resources = [];


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
    #[On('category-search')]
    public function getCategories($recordId)
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

    public function mount($recordId = null)
    {
        $this->catRes = $recordId;
        $this->resources = $this->getResources();
        $this->categories = Category::paginate(25)->toArray();
    }
    public function getResources()
    {
        return Resource::when($this->searchTerm, function ($query) {
            $query->where('title', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
                ->orWhere('abstract', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
                ->orWhere('authors', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
                ->orWhere('tags', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%')
                ->orWhere('category_id', '=', $this->catRes)
                ->orWhereHas('category', function ($q) {
                    $q->where('name', 'like', '%' . $this->sanitizeSearchTerm($this->searchTerm) . '%');
                });
        })
            ->when($this->catRes, function ($query) {
                $query->where('category_id', '=', $this->catRes);
            })
            ->with('category')
            ->select('id', 'title', 'abstract', 'authors', 'created_at', 'year_of_publication', 'cover_image', 'category_id')
            ->paginate(9)->toArray();
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

    public function attachMember($recordId)
    {

        $resource = Resource::find($recordId);
        $member = filament::auth()->user()->id;

        $alreadyExists = $resource->members()->where('user_id', $member)->exists();
        if ($alreadyExists) {
            Notification::make()
                ->title('Record already added to your reading list')
                ->warning()
                ->send();
        } else {
            $resourceMemberAdded = $resource->members()->syncWithoutDetaching($member);

            // Notify only if the member was successfully added
            if ($resourceMemberAdded) {
                Notification::make()
                    ->title('Resource added to your reading list successfully')
                    ->success()
                    ->send();
            }
        }

    }



}
