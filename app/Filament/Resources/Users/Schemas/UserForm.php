<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nombre')->required()->maxLength(255),
            TextInput::make('email')->label('Email')->email()->required()->unique(ignoreRecord: true),
            TextInput::make('password')
                ->label('Contraseña')->password()
                ->dehydrateStateUsing(fn ($s) => bcrypt($s))
                ->dehydrated(fn ($s) => filled($s))
                ->required(fn (string $context) => $context === 'create'),
            Select::make('roles')->label('Rol')
                ->relationship('roles', 'name')
                ->options([
                    'admin'     => 'Admin',
                    'medico'    => 'Médico',
                    'asistente' => 'Asistente',
                ])->required(),
        ]);
    }
}