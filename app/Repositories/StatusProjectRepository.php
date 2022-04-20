<?php

namespace App\Repositories;

use App\Intefaces\StatusProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci se stavy projektů
 */
class StatusProjectRepository implements StatusProjectRepositoryInterface
{

    /**
     * Metoda vrátí všechny stavy projektů
     * @return array Pole všech stavů projektů
     */
    public function getAllStatusProject(): array
    {
        return DB::select('
            SELECT * FROM status_project;
        ');
    }
}
