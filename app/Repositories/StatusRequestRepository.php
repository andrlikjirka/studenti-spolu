<?php

namespace App\Repositories;

use App\Intefaces\StatusRequestRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StatusRequestRepository implements StatusRequestRepositoryInterface
{
    public function getAllStatusRequest()
    {
        return DB::select('SELECT * FROM status_request');
    }
}
