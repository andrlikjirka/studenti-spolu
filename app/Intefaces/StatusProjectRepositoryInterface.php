<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci se stavy projektů
 */
interface StatusProjectRepositoryInterface
{
    /** Metoda vrátí všechny stavy projektů */
    public function getAllStatusProject();
}
