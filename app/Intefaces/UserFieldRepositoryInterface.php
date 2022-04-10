<?php

namespace App\Intefaces;

interface UserFieldRepositoryInterface
{
    public function getUserFieldsByUserId($id_user);
    public function editUserFields($id_user, $fields);
}
