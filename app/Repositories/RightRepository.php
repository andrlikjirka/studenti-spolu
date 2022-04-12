<?php

namespace App\Repositories;

use App\Intefaces\RightRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RightRepository implements RightRepositoryInterface
{

    public function getAllRights()
    {
        return DB::select('SELECT * FROM `right`');
    }
}
