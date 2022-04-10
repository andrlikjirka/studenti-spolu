<?php

namespace App\Repositories;

use App\Intefaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function getAllActiveUsers()
    {
        return DB::select('
                SELECT u.id_user, u.first_name, u.last_name, u.email, u.id_status FROM users u
                    WHERE id_status = 1;
            ');
    }

    public function getSearchActiveUsers($first_name, $last_name)
    {
        return DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.email, u.id_status FROM users u
                WHERE id_status = 1
                AND   u.first_name LIKE :first_name
                AND   u.last_name LIKE :last_name;
        ', [':first_name' => $first_name, ':last_name' => $last_name]);
    }

    public function getActiveUserById($id_user)
    {
        return DB::select('
            SELECT u.id_user, u.first_name, u.last_name, u.login, u.email, u.description
                FROM users u
                WHERE u.id_user = :id_user
                AND   u.id_status = 1;
        ', [
            ':id_user' => $id_user,
        ]);
    }

    public function getUserFieldsByUserId($id_user)
    {
        return DB::select('
            SELECT f.id_field as f_id_field, f.name as f_name FROM users_field uf, field f
            WHERE uf.id_field = f.id_field
            AND   id_user = :id_user;
        ', [':id_user' => $id_user]);
    }



}
