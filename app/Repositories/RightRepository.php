<?php

namespace App\Repositories;

use App\Intefaces\RightRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci s právy
 */
class RightRepository implements RightRepositoryInterface
{
    /**
     * Metoda vrátí všechna práva uživatelů
     * @return array Pole všech práv uživatelů
     */
    public function getAllRights(): array
    {
        return DB::select('SELECT * FROM `right`');
    }
}
