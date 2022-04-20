<?php

namespace App\Repositories;

use App\Intefaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci s projekty
 */
class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * Metoda vrátí všechny projekty
     * @return array Pole všech projektů
     */
    public function getAllProjects(): array
    {
        return DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.id_status as s_id_status, DATE(p.create_date) as create_date,
                   s.name as s_name, u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.id_status as u_id_status
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_status = :id_status
                AND   r.id_role = :id_role
            ORDER BY p.create_date DESC;
        ', [':id_status' => 1, ':id_role' => 1]);
    }

    /**
     * Metoda vrátí vyhledané projekty dle jejich názvu
     * @param string $projectName Název projektu
     * @return array Pole vyhledaných projektů
     */
    public function getSearchProjects($projectName): array
    {
        return DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, s.id_status as s_id_status, DATE(p.create_date) as create_date,
                   s.name as s_name, u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, u.id_status as u_id_status
            FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   u.id_status = :id_status
                AND   r.id_role = :id_role
                AND   p.name LIKE :p_name
            ORDER BY p.create_date DESC;
        ', [':id_status' => 1, ':id_role' => 1, ':p_name' => $projectName]);
    }

    /**
     * Metoda vrátí konkrétní projekt
     * @param int $id_project ID projektu
     * @return array Konkrétní projekt
     */
    public function getProjectById($id_project)
    {
        return DB::select('
            SELECT p.id_project as id_project, p.name as name, p.abstract as abstract, p.description as description, s.id_status as s_id_status,
                   s.name as s_name, u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
            FROM project p, cooperation c, users u, status_project s
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   p.id_project = :id_project
                AND   c.id_role = :id_role
                AND   u.id_status = :id_status;
        ', [':id_project' => $id_project, ':id_role' => 1, ':id_status' => 1]);
    }

    /**
     * Metoda vrátí projekty konkrétního uživatele
     * @param int $id_user ID uživatele
     * @param int $id_role ID role na projektu
     * @return array Pole projektů uživatele
     */
    public function getProjectsByUserId($id_user, $id_role)
    {
        return DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, p.abstract as p_abstract, s.id_status as s_id_status,
                   s.name as s_name, u.first_name as u_first_name, u.last_name as u_last_name, DATE(p.create_date) as create_date
                FROM project p, cooperation c, users u, status_project s, role r
                WHERE p.id_project = c.id_project
                AND   c.id_user = u.id_user
                AND   p.id_status = s.id_status
                AND   r.id_role = c.id_role
                AND   r.id_role = 1
                AND p.id_project IN (
                    SELECT c.id_project FROM cooperation c
                        WHERE   c.id_user = :id_user
                        AND   c.id_role = :id_role
                )
            ORDER BY p.create_date DESC;
        ', [
            ':id_user' => $id_user,
            ':id_role' => $id_role,
        ]);
    }

    /**
     * Metoda upraví vybraný projekt
     * @param int $id_project ID projektu
     * @param string $edit_name Název projektu
     * @param string $edit_abstract Abstrakt projektu
     * @param string $edit_description Popis projektu
     * @param int $edit_status ID stavu projektu
     * @return int Výsledek úpravy projektu
     */
    public function editProjectById($id_project, $edit_name, $edit_abstract, $edit_description, $edit_status)
    {
        return DB::update('
            UPDATE project
                SET name = :name, abstract = :abstract,
                    description = :description, id_status = :id_status
                WHERE id_project = :id_project;
        ', [':name' => $edit_name, ':abstract' => $edit_abstract, ':description' => $edit_description,
            ':id_status' => $edit_status, ':id_project' => $id_project]);
    }

    /**
     * Metoda vytvoří nový projekt
     * @param int $logged_user_id ID přihlášeného uživatele
     * @param string $name Název projektu
     * @param string $abstract Abstrakt projektu
     * @param string $description Popis projektu
     * @param mixed $create_date Datum vytvoření projektu
     * @param int $status ID stavu projektu
     * @return mixed Výsledek vytvoření nového projektu (1 - úspěšné, 0 - neúspěšné)
     */
    public function createNewProject($logged_user_id, $name, $abstract, $description, $create_date, $status = 1)
    {
        return DB::transaction(function () use ($name, $abstract, $description, $create_date, $logged_user_id) {
            // Vložení záznamu o novém týmovém projektu do tabulky Projekt
            DB::insert('
            INSERT INTO project(name, abstract, description, create_date, id_status)
            VALUES (:name, :abstract, :description, :create_date, :id_status)
        ', [
                ':name' => $name,
                ':abstract' => $abstract,
                'description' => $description,
                'create_date' => $create_date,
                'id_status' => 1
            ]);

            $projectID = DB::getPdo()->lastInsertId();

            // Vložení záznamu do tabulky Spolupráce (kdo je autorem na nově vytvořeném projektu)
            DB::insert('
            INSERT INTO cooperation(id_user, id_project, id_role)
            VALUES (:id_user, :id_project, :id_role)
        ', [
                ':id_user' => $logged_user_id,
                ':id_project' => $projectID,
                ':id_role' => 1
            ]);
        });
    }

    /**
     * Metoda odstraní vybraný projekt
     * @param int $id_project ID projektu
     * @return int Výsledek odstranění projektu (1 - úspěšné | 0 - neúspěšné)
     */
    public function deleteProjectById($id_project)
    {
        return DB::delete('
            DELETE FROM project WHERE id_project=:id_project
        ', ['id_project' => $id_project]);
    }
}
