<?php

namespace App\Repositories;

use App\Intefaces\UserFieldRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci s obory znalostí a dovedností uživatelů
 */
class UserFieldRepository implements UserFieldRepositoryInterface
{
    /**
     * Metoda vrátí obory, ve kterých má uživatel znalosti a dovednosti
     * @param int $id_user ID uživatele
     * @return array Pole oborů, ve kterých má uživatel znalosti a dovednosti
     */
    public function getUserFieldsByUserId($id_user): array
    {
        return DB::select('
            SELECT id_field FROM users_field WHERE id_user=:id_user;
        ', [':id_user' => $id_user]);
    }

    /**
     * Metoda upraví obory, ve kterých má uživatel znalosti a dovednosti
     * @param int $id_user ID uživatele
     * @param mixed $fields Obory
     * @return mixed Výsledek úpravy oborů znalostí a dovedností
     */
    public function editUserFields($id_user, $fields): mixed
    {
        return DB::transaction(function () use ($id_user, $fields){
            DB::delete('DELETE FROM users_field WHERE id_user = :id_user', [':id_user' => $id_user]);
            foreach ($fields as $field) {
                DB::insert('
                INSERT INTO users_field(id_user, id_field)
                VALUES (:id_user, :id_field)
            ', [':id_user' => $id_user, 'id_field' => $field]);
            }
        });
    }
}
