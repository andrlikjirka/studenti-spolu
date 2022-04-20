<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci se stavy uživatelů
 */
interface StatusUserRepositoryInterface
{
    /** Metoda vrátí všechny stavy uživatelů */
    public function getAllStatusUser();
}
