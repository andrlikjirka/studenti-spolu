<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci se stavy nabídek spolupráce
 */
interface StatusOfferRepositoryInterface
{
    /** Metoda vrátí všechny stavy nabídek spolupráce */
    public function getAllStatusOffer();
}
