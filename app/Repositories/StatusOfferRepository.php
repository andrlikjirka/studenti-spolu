<?php

namespace App\Repositories;

use App\Intefaces\StatusOfferRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci se stavy nabídek spolupráce
 */
class StatusOfferRepository implements StatusOfferRepositoryInterface
{
    /**
     * Metoda vrátí všechny stavy nabídek spolupráce
     * @return array Pole všech stavů nabídek spolupráce
     */
    public function getAllStatusOffer(): array
    {
        return DB::select('
            SELECT * FROM status_offer;
        ');
    }
}
