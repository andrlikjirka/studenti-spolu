<?php

namespace App\Repositories;

use App\Intefaces\StatusProjectRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StatusProjectRepository implements StatusProjectRepositoryInterface
{

    public function getAllStatusProject()
    {
        return DB::select('
            SELECT * FROM status_project;
        ');
    }
}
