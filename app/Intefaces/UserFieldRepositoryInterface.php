<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci s obory znalostí a dovedností uživatelů
 */
interface UserFieldRepositoryInterface
{
    /** Metoda vrátí obory, ve kterých má uživatel znalosti a dovednosti */
    public function getUserFieldsByUserId($id_user);
    /** Metoda upraví obory, ve kterých má uživatel znalosti a dovednosti */
    public function editUserFields($id_user, $fields);
}
