<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci s obory
 */
interface FieldRepositoryInterface
{
    /** Metoda vrátí všechny obory */
    public function getAllFields();
}
