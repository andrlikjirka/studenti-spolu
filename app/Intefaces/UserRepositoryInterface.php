<?php

namespace App\Intefaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getAllActiveUsers();
    public function getSearchActiveUsers($first_name, $last_name);
    public function getUserById($id_user);
    public function getActiveUserById($id_user);
    public function getUserFieldsByUserId($id_user);
    public function getTeamMembersByProjectId($id_project);
    public function removeTeamMember($id_project, $id_user);
    public function getUserAsTeamMember($id_user, $id_project);
    public function editUserById($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description);
    public function editUserByIdSuperAdmin($id_user, $edit_first_name, $edit_last_name, $edit_email, $edit_description, $edit_id_status, $edit_id_right);
    public function deleteUserById($id_user, $projects, ProjectRepositoryInterface $projectRepository);
}
