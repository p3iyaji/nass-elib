<?php

use App\Filament\App\Pages\Books;
use App\Filament\App\Pages\PreviewResource;
use App\Filament\App\Pages\ViewResource;
use App\Livewire\ResourceCategory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('config_cache', function(){
   \Artisan::call('config:cache');
});

Route::get('/size-test', function(){
   return phpinfo();
});
Route::get('/app/preview-resource/{recordId}', PreviewResource::class)
    ->name('filament.app.pages.preview-resource');

Route::get('/app/resource-categories/{recordId}', ResourceCategory::class)->name('resource-categories');
Route::get('/app/books/{recordId}', Books::class)->name('filament.app.pages.books');
Route::get('/view-resource/{recordId}', ViewResource::class)->name('view-resource');

