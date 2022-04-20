<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci s uživateli
 */
interface UserRepositoryInterface
{
    /** Metoda vrátí všechny uživatele */
    public function getAllUsers();
    /** Metoda vrátí aktivní uživatele */
    public function getAllActiveUsers();
    /** Metoda vrátí aktivní uživatele odpovídající vyhledávání */
    public function getSearchActiveUsers($first_name, $last_name);
    /** Metoda vrátí konkrétního uživatele */
    public function getUserById($id_user);
    /** Metoda vrátí konkrétního aktivního uživatele */
    public function getActiveUserById($id_user);
    /** Metoda vrátí obory, ve kterých má uživatel znalosti a dovednosti */
    public function getUserFieldsByUserId($id_user);
    /** Metoda vrátí uživatele, kteří jsou členy týmu na projektu */
    public function getTeamMembersByProjectId($id_project);
    /** Metoda odstraní vybraného uživatele z projektového týmu */
    public function removeTeamMember($id_project, $id_user);
    /** Metoda zjistí, zda je uživatel členem týmu */
    public function getUserAsTeamMember($id_user, $id_project);
    /** Metoda upraví vybraného uživatele */
    public function editUserById($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description);
    /** Metoda upraví vybraného uživatele i s jeho právy (jen pro SuperAdmin) */
    public function editUserByIdSuperAdmin($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description, $edit_id_status, $edit_id_right);
    /** Metoda odstraní vybraného uživatele */
    public function deleteUserById($id_user, $projects, ProjectRepositoryInterface $projectRepository);
}
