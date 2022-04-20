<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci se stavy žádostí o spolupráci
 */
interface StatusRequestRepositoryInterface
{
    /** Metoda vrátí všechny stavy žádostí o spolupráci */
    public function getAllStatusRequest();
}
