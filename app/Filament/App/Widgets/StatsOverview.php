<?php

namespace App\Filament\App\Widgets;

use App\Filament\App\Pages\Categories;
use App\Models\Category;
use App\Models\Resource;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $categories = Category::count();
        $resources = Resource::count();
        $readinglist = Resource::whereHas('members', function ($query) {
            $query->where('user_id', filament::auth()->user()->id);
        })->count();

        return [
            Stat::make('Total Resource Categories', $categories)
                ->icon('heroicon-o-clipboard-document-list')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-primary-100 hover:text-primary-500 transition-colors duration-200',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
            Stat::make('Total Available Resources', $resources)
                ->color('danger')
                ->icon('heroicon-o-book-open')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-primary-100 hover:text-primary-500 transition-colors duration-200',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),
            Stat::make('My Reading list', $readinglist)
                ->color('success')
                ->icon('heroicon-o-list-bullet')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-primary-100 hover:text-primary-500 transition-colors duration-200',
                    'wire:click' => "\$dispatch('setStatusFilter', { filter: 'processed' })",
                ]),

        ];
    }

}
