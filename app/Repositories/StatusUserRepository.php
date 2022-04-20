<?php

namespace App\Repositories;

use App\Intefaces\StatusUserRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci se stavy uživatelů
 */
class StatusUserRepository implements StatusUserRepositoryInterface
{
    /**
     * Metoda vrátí všechny stavy uživatelů
     * @return array Pole stavů uživatelů
     */
    public function getAllStatusUser(): array
    {
        return DB::select('SELECT * FROM status_user;');
    }
}
