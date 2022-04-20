<?php

namespace App\Repositories;

use App\Intefaces\FieldRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci s obory
 */
class FieldRepository implements FieldRepositoryInterface
{

    /**
     * Metoda vrátí všechny obory
     * @return array Pole všech oborů
     */
    public function getAllFields(): array
    {
        return DB::select('
            SELECT * FROM field;
        ');
    }
}
