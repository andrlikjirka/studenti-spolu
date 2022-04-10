<?php

namespace App\Intefaces;

interface UserRepositoryInterface
{
    public function getAllActiveUsers();
    public function getSearchActiveUsers($first_name, $last_name);
    public function getActiveUserById($id_user);
    public function getUserFieldsByUserId($id_user);

}
