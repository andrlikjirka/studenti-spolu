<?php

namespace App\Repositories;

use App\Intefaces\StatusUserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StatusUserRepository implements StatusUserRepositoryInterface
{

    public function getAllStatusUser()
    {
        return DB::select('SELECT * FROM status_user;');
    }
}
