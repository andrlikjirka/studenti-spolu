<?php

namespace App\Repositories;

use App\Intefaces\StatusOfferRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StatusOfferRepository implements StatusOfferRepositoryInterface
{

    public function getAllStatusOffer()
    {
        return DB::select('
            SELECT * FROM status_offer;
        ');
    }
}
