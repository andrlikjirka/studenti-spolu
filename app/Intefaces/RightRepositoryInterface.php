<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci s právy
 */
interface RightRepositoryInterface
{
    /** Metoda vrátí všechna práva uživatelů */
    public function getAllRights();
}
