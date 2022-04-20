<?php

namespace App\Repositories;

use App\Intefaces\RequestCooperationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci se žádostmi o spolupráci
 */
class RequestCooperationRepository implements RequestCooperationRepositoryInterface
{
    /**
     * Metoda vrátí všechny žádosti o spolupráci
     * @return array Pole všech žádostí o spolupráci
     */
    public function getAllRequests(): array
    {
        return DB::select('
            SELECT r.id_request as r_id_request, r.message as r_message, DATE(r.create_date) as r_create_date,
                    o.id_offer as o_id_offer, o.name as o_name, p.id_project as p_id_project,
                    p.name as p_name, f.name as f_name, s.id_status as s_id_status, s.name as s_name
                FROM request_cooperation r, offer_cooperation o, status_request s, project p, field f
                    WHERE r.id_offer = o.id_offer
                    AND   o.id_project = p.id_project
                    AND   o.id_field = f.id_field
                    AND   r.id_status = s.id_status
                ORDER BY r.create_date DESC, s.id_status;
            ');
    }

    /**
     * Metoda vrátí všechny přijaté žádosti o spolupráci
     * @param int $id_user ID uživatele
     * @return array Pole všeech přijatých žádostí o spolupráci
     */
    public function getAllRecievedRequests($id_user): array
    {
        return DB::select('
            SELECT r.id_request as r_id_request, r.message as r_message, DATE(r.create_date) as r_create_date,
                   o.id_offer as o_id_offer, o.name as o_name, p.id_project as p_id_project, p.name as p_name,
                   u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name,
                   s.id_status as s_id_status, s.name as s_name, f.name as f_name
            FROM request_cooperation r, offer_cooperation o, project p, users u, field f, status_request s
            WHERE r.id_offer = o.id_offer
            AND   r.id_user = u.id_user
            AND   r.id_status = s.id_status
            AND   o.id_project = p.id_project
            AND   o.id_field = f.id_field
            AND   p.id_project IN (
                SELECT p.id_project FROM project p, cooperation c
                    WHERE p.id_project = c.id_project
                    AND   c.id_user = :id_user
                    AND   c.id_role = :id_role
                )
            ORDER BY r.create_date DESC, s.id_status;
        ', [
            ':id_user' => $id_user,
            ':id_role' => 1 //uzivatel je autor projektu
        ]);
    }

    /**
     * Metoda vrátí všechny odeslané žádosti o spolupráci
     * @param int $id_user ID uživatele
     * @return array Pole odeslaných žádostí o spolupráci
     */
    public function getAllSentRequests($id_user): array
    {
        return DB::select('
            SELECT r.id_request as r_id_request, r.message as r_message, DATE(r.create_date) as r_create_date,
                o.id_offer as o_id_offer, o.name as o_name, p.id_project as p_id_project,
                p.name as p_name, f.name as f_name, s.id_status as s_id_status, s.name as s_name
            FROM request_cooperation r, offer_cooperation o, status_request s, project p, field f
                WHERE r.id_offer = o.id_offer
                AND   o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   r.id_status = s.id_status
                AND   id_user = :id_user
            ORDER BY r.create_date DESC, s.id_status;
        ', [
            ':id_user' => $id_user,
        ]);
    }

    /**
     * Metoda vrátí konkrétní žádost o spolupráci
     * @param int $id_request ID žádosti o spolupráci
     * @return array Konkrétní žádost o spolupráci
     */
    public function getRequestById($id_request): array
    {
        return DB::select('
            SELECT r.id_request as r_id_request, r.message as r_message, DATE(r.create_date) as r_create_date,
                o.id_offer as o_id_offer, o.name as o_name, p.id_project as p_id_project,
                p.name as p_name, f.name as f_name, s.id_status as s_id_status, s.name as s_name,
                u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name
            FROM request_cooperation r, offer_cooperation o, status_request s, project p, field f, users u
                WHERE r.id_offer = o.id_offer
                AND   o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   r.id_status = s.id_status
                AND   r.id_user = u.id_user
                AND   r.id_request = :id_request
            ORDER BY r.create_date DESC, s.id_status;
        ', [
            ':id_request' => $id_request,
        ]);
    }

    /**
     * Metoda vytvoří novou žádost o spolupráci
     * @param string $message Zpráva žádosti o spolupráci
     * @param mixed $create_date Datum vytvoření žádosti o spolupráci
     * @param int $id_user ID uživatele
     * @param int $id_offer ID nabídky spolupráce
     * @param int $id_status ID stavu žádosti o spolupráci
     * @return bool Výsledek vytvoření nové žádosti o spolupráci
     */
    public function createNewRequest($message, $create_date, $id_user, $id_offer, $id_status = 1): bool
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

    /**
     * Metoda zjistí, zda uživatel odeslal žádost, která čeká na schválení
     * @param int $id_user ID uživatele
     * @param int $id_offer ID nabídky spolupráce
     * @return array Pole odeslaných žádostí o spolupráci ve stavu Čeká na vyřízení
     */
    public function userAlreadySentWaitingRequestByOfferId($id_user, $id_offer): array
    {
        return DB::select('
        SELECT id_request FROM request_cooperation
        WHERE id_user = :id_user
        AND   id_status = :id_status
        AND   id_offer = :id_offer;
        ', [
            ':id_user' => $id_user,
            ':id_status' => 1, //čekající na vyřízení
            ':id_offer' => $id_offer
        ]);
    }

    /**
     * Metoda vrátí konkrétní žádost před úpravou
     * @param int $id_request ID žádosti o spolupráci
     * @return array Konkrétní žádost o spolupráci
     */
    public function getOldRequestBeforeEdit($id_request): array
    {
        return DB::select('
            SELECT * FROM request_cooperation WHERE id_request=:id_request;
        ', [':id_request' => $id_request]);
    }

    /**
     * Metoda upraví konkrétní žádost o spolupráci
     * @param int $id_request ID žádosti o spolupráci
     * @param string $edit_request_message Upravená zpráva žádosti o spolupráci
     * @return int Výsledek úpravy žádosti o spolupráci
     */
    public function editRequestById($id_request, $edit_request_message): int
    {
        return DB::update('
            UPDATE request_cooperation
                SET message = :message
                WHERE id_request = :id_request;
        ', [
            ':message' => $edit_request_message,
            ':id_request' => $id_request,
        ]);
    }

    /**
     * Metoda odstraní konkrétní žádost o spolupráci
     * @param int $id_request ID žádost o spolupráci
     * @return int Výsledek odstranění žádosti o spolupráci (1- úspěšné | 0 - neúspěšné)
     */
    public function deleteRequestById($id_request): int
    {
        return DB::delete('
            DELETE FROM request_cooperation WHERE id_request = :id_request
        ', [':id_request' => $id_request]);
    }

    /**
     * Metoda schválí konkrétní žádost o spolupráci
     * @param int $id_request ID žádosti o spolupráci
     * @param int $id_project ID projektu
     * @param int $id_user ID uživatele
     * @return mixed Výsledek schválení žádosti o spolupráci
     */
    public function acceptRequestById($id_request, $id_project, $id_user): mixed
    {
        return DB::transaction(function () use ($id_request, $id_project, $id_user) {
            DB::update('
            UPDATE request_cooperation
                SET id_status = :id_status
                WHERE id_request = :id_request;
            ', [
                ':id_status' => 2,
                ':id_request' => $id_request
            ]);
            DB::insert('
                INSERT INTO cooperation(id_user, id_project, id_role)
                VALUES (:id_user, :id_project, :id_role);
            ', [
                ':id_user' => $id_user,
                ':id_project' => $id_project,
                ':id_role' => 2
            ]);
        });
    }

    /**
     * Metoda zamítne konkrétní žádost o spolupráci
     * @param int $id_request ID žádosti o spolupráci
     * @return mixed Výsledek zamítnutí žádosti o spolupráci
     */
    public function rejectRequestById($id_request): mixed
    {
        return DB::transaction(function () use ($id_request) {
            DB::update('
            UPDATE request_cooperation
                SET id_status = :id_status
                WHERE id_request = :id_request;
            ', [
                ':id_status' => 3,
                ':id_request' => $id_request
            ]);
        });
    }

    /**
     * Metoda vrátí žádost o spolupráci do stavu Čeká na vyřízení
     * @param int $id_request ID žádosti o spolupráci
     * @param int $id_project ID projektu
     * @param int $id_user ID uživatele
     * @return mixed Výsledek znovuposouzení žádosti o spolupráci
     */
    public function setWaitingRequestById($id_request, $id_project, $id_user): mixed
    {
        return DB::transaction(function () use ($id_request, $id_project, $id_user) {
            DB::update('
            UPDATE request_cooperation
                SET id_status = :id_status
                WHERE id_request = :id_request;
            ', [
                ':id_status' => 1,
                ':id_request' => $id_request
            ]);
            DB::delete('
                DELETE FROM cooperation
                WHERE id_user = :id_user AND id_project = :id_project AND id_role = :id_role
            ', [
                ':id_user' => $id_user,
                ':id_project' => $id_project,
                ':id_role' => 2
            ]);
        });
    }

}

