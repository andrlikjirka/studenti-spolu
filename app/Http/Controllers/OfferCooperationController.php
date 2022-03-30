<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferCooperationController extends Controller
{


    public function index()
    {
        $title = 'Nabídky spolupráce';

        $offers = DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
                DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                ORDER BY o.create_date DESC;
        ');

        return view('nabidky-spoluprace/index')
                ->with('title', $title)
                ->with('offers', $offers);
    }

    public function show($id)
    {

    }

    public function create()
    {

    }

    public function edit()
    {

    }

    public function store()
    {

    }

    public function destroy()
    {

    }

}
