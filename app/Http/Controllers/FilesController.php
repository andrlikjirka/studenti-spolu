<?php

namespace App\Http\Controllers;

use App\Intefaces\FileRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Třída reprezentující kontroller pro zobrazení souborů
 */
class FilesController extends Controller
{
    /** @var FileRepositoryInterface Atribut typu repository pro práci se soubory */
    private $files;

    /**
     * Konstruktor třídy
     * @param $files FileRepositoryInterface Rozhraní třídy pro práci se soubory
     */
    public function __construct(FileRepositoryInterface $files)
    {
        $this->files = $files;
    }

    /**
     * Metoda zajišťuje zobrazení konkrétního souboru
     * @param $id int ID souboru
     * @return mixed Přesměrování na konkrétní route
     */
    public function show($id)
    {
        if (Auth::check()) {
            $fileInfo = $this->files->getFileInfoById($id);
            if (count($fileInfo) == 1) {
                $file_extension = $fileInfo[0]->type;
                $file = basename($fileInfo[0]->unique_name.'.'.$file_extension);
                $fileName = $fileInfo[0]->name;
                if ($file) {
                    return Storage::disk('s3')->response('uploads/'. $file, $fileName);
                } else {
                    abort(404, 'Soubor nenalezen');
                }
            } else {
                abort(404, 'Soubor nenalezen');
            }
        } else {
            abort(403);
        }
        return redirect()->route('index');
    }
}
