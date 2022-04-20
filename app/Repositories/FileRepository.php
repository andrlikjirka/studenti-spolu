<?php

namespace App\Repositories;

use App\Intefaces\FileRepositoryInterface;
use Illuminate\Support\Facades\DB;

/**
 * Rozhraní obalové třídy pro práci se soubory
 */
class FileRepository implements FileRepositoryInterface
{
    /**
     * Metoda vrátí soubory nahrané ke konkrétnímu projektu
     * @param $id_project
     * @return array
     */
    public function getFilesByProjectId($id_project): array
    {
        return DB::select('
           SELECT * FROM file WHERE id_project = :id_project;
        ', [':id_project' => $id_project]);
    }

    /**
     * Metoda zajistí upload souboru k vybranému projektu
     * @param int $id_project ID projektu
     * @param string $originalName Originální název souboru
     * @param string $uniqueName Unikátní název souboru
     * @param string $type Typ souboru
     * @param mixed $uploadDate Datum nahrání souboru
     * @return bool True pokud je upload úspěšný | False pokud je upload neúspěšný
     */
    public function uploadFile($id_project, $originalName, $uniqueName, $type, $uploadDate): bool
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

    /**
     * Metoda vrátí informace o konkrétním souboru
     * @param int $id_file ID souboru
     * @return array Informace o vybraném souboru
     */
    public function getFileInfoById($id_file): array
    {
        return DB::select('SELECT * FROM file WHERE id_file=:id_file',
            [':id_file' => $id_file]);
    }

    /**
     * Metoda zajistí ostranění konkrétního souboru
     * @param int $id_file ID souboru
     * @return int Výsledek odstranění souboru (1 úspěšné | 0 neúspěšné)
     */
    public function deleteFile($id_file): int
    {
        return DB::delete('
            DELETE FROM file WHERE id_file = :id_file;
        ', [':id_file' => $id_file]);
    }
}
