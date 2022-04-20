<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci s projekty
 */
interface ProjectRepositoryInterface
{
    /** Metoda vrátí všechny projekty */
    public function getAllProjects();
    /** Metoda vrátí vyhledané projekty dle jejich názvu */
    public function getSearchProjects($projectName);
    /** Metoda vrátí konkrétní projekt */
    public function getProjectById($id_project);
    /** Metoda vrátí projekty konkrétního uživatele */
    public function getProjectsByUserId($id_user, $id_role);
    /** Metoda upraví vybraný projekt */
    public function editProjectById($id_project, $name, $abstract, $description, $status);
    /** Metoda vytvoří nový projekt */
    public function createNewProject($logged_user_id, $name, $abstract, $description, $create_date, $status = 1);
    /** Metoda odstraní vybraný projekt */
    public function deleteProjectById($id_project);
}
