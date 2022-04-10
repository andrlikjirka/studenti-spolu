<?php

namespace App\Repositories;

use App\Intefaces\FieldRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FieldRepository implements FieldRepositoryInterface
{

    public function getAllFields()
    {
        return DB::select('
            SELECT * FROM field;
        ');
    }
}
