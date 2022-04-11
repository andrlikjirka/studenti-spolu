<?php

namespace App\Intefaces;

interface UserRepositoryInterface
{
    public function getAllActiveUsers();
    public function getSearchActiveUsers($first_name, $last_name);
    public function getActiveUserById($id_user);
    public function getUserFieldsByUserId($id_user);
    public function getTeamMembersByProjectId($id_project);
    public function removeTeamMember($id_project, $id_user);
    public function getUserAsTeamMember($id_user, $id_project);
}
