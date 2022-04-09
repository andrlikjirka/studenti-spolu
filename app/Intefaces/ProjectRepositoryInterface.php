<?php

namespace App\Intefaces;

interface ProjectRepositoryInterface
{
    public function getAllProjects();
    public function getSearchProjects($projectName);
    public function getProjectById($id_project);
    public function getTeamMembersByProjectId($id_project);
    public function getOffersCooperationByProjectId($id_project);
    public function getFilesByProjectId($id_project);
}
