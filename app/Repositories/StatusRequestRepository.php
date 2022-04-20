<?php

namespace App\Repositories;

use App\Intefaces\StatusRequestRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci se stavy žádostí o spolupráci
 */
class StatusRequestRepository implements StatusRequestRepositoryInterface
{
    /**
     * Metoda vrátí všechny stavy žádostí o spolupráci
     * @return array Pole všech stavů žádostí o spolupráci
     */
    public function getAllStatusRequest(): array
    {
        return DB::select('SELECT * FROM status_request');
    }
}
