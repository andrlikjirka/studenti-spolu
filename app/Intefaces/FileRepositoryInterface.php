<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci se soubory
 */
interface FileRepositoryInterface
{
    /** Metoda vrátí soubory nahrané ke konkrétnímu projektu */
    public function getFilesByProjectId($id_project);
    /** Metoda zajistí upload souboru k vybranému projektu */
    public function uploadFile($id_project, $originalName, $uniqueName, $type, $uploadDate);
    /** Metoda zajistí ostranění konkrétního souboru */
    public function deleteFile($id_file);
    /** Metoda vrátí informace o konkrétním souboru */
    public function getFileInfoById($id_file);
}
