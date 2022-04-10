<?php

namespace App\Repositories;

use App\Intefaces\OfferCooperationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfferCooperationRepository implements OfferCooperationRepositoryInterface
{
    public function getAllOffers($id_status = 1)
    {
        return DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
                DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   s.id_status = :id_status
                ORDER BY o.create_date DESC;
        ', [':id_status' => $id_status]);
    }

    public function getMatchOffers($id_status = 1)
    {
        return DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
                DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   s.id_status = :id_status
                AND   f.id_field IN (
                    SELECT u.id_field FROM users_field u
                        WHERE u.id_user = :id_user
                )
                ORDER BY o.create_date DESC;
        ', [':id_status' => $id_status,':id_user' => Auth::id() ]);
    }

    public function getOfferById($id_offer, $id_status = 1)
    {
        return DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
                DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, field f, project p, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   s.id_status = :id_status
                AND   o.id_offer = :id_offer;
            ', [
            ':id_status' => $id_status,
            ':id_offer' => $id_offer,
        ]);
    }

    public function createNewRequest($message, $create_date, $id_user, $id_offer, $id_status = 1)
    {
        return DB::insert('
            INSERT INTO request_cooperation (message, create_date, id_user, id_offer, id_status)
            VALUES (:message, :create_date, :id_user, :id_offer, :id_status);
        ', [
            ':message' => $message,
            ':create_date' => $create_date,
            ':id_user' => $id_user,
            ':id_offer' => $id_offer,
            ':id_status' => $id_status,
        ]);
    }

    public function getOffersByProjectId($id_project)
    {
        return DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer, o.name as o_name, o.description as o_description,
                   DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                   s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   p.id_project = :id_project
                ORDER BY o.create_date;
        ', [
            ':id_project' => $id_project,
        ]);
    }

}
