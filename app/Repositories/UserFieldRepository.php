<?php

namespace App\Repositories;

use App\Intefaces\UserFieldRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserFieldRepository implements UserFieldRepositoryInterface
{

    public function getUserFieldsByUserId($id_user)
    {
        return DB::select('
            SELECT id_field FROM users_field WHERE id_user=:id_user;
        ', [':id_user' => $id_user]);
    }

    public function editUserFields($id_user, $fields)
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
