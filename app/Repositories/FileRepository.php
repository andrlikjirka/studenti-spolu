<?php

namespace App\Repositories;

use App\Intefaces\FileRepositoryInterface;
use Illuminate\Support\Facades\DB;

class FileRepository implements FileRepositoryInterface
{

    public function getFilesByProjectId($id_project)
    {
        return DB::select('
           SELECT * FROM file WHERE id_project = :id_project;
        ', [':id_project' => $id_project]);
    }

    public function uploadFile($id_project, $originalName, $uniqueName, $type, $uploadDate)
    {
        return DB::insert('
            INSERT INTO file(name, unique_name, type, upload_date, id_project)
            VALUES (:name, :unique_name, :type, :upload_date, :id_project);
            ', [
            ':name' => $originalName,
            ':unique_name' => $uniqueName,
            ':type' => $type,
            ':upload_date' => $uploadDate,
            ':id_project' => $id_project,
        ]);
    }

    public function getFileInfoById($id_file)
    {
        return DB::select('SELECT * FROM file WHERE id_file=:id_file',
            [':id_file' => $id_file]);
    }

    public function deleteFile($id_file)
    {
        return DB::delete('
            DELETE FROM file WHERE id_file = :id_file;
        ', [':id_file' => $id_file]);
    }
}
