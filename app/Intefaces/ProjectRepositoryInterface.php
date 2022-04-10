<?php

namespace App\Intefaces;

interface ProjectRepositoryInterface
{
    public function getAllProjects();
    public function getSearchProjects($projectName);
    public function getProjectById($id_project);
    public function getTeamMembersByProjectId($id_project);
    public function removeTeamMember($id_project, $id_user);
    public function getOffersCooperationByProjectId($id_project);
    public function getProjectsByUserId($id_user, $id_role);
    public function editProjectById($id_project, $name, $abstract, $description, $status);
    public function createNewProject($logged_user_id, $name, $abstract, $description, $create_date, $status = 1);
    public function deleteProjectById($id_project);
}
