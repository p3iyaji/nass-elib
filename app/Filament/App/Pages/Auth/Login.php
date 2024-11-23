<?php

namespace App\Filament\App\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseAuth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Illuminate\Contracts\Support\Htmlable;


class Login extends BaseAuth
{
//    protected static ?string $navigationIcon = 'heroicon-o-document-text';
//
//    protected static string $view = 'filament.app.pages.auth.login';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                //$this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Login')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }




}
