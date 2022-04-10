<?php

namespace App\Intefaces;

interface FileRepositoryInterface
{
    public function getFilesByProjectId($id_project);
    public function uploadFile($id_project, $originalName, $uniqueName, $type, $uploadDate);
    public function deleteFile($id_file);
    public function getFileInfoById($id_project);
}
