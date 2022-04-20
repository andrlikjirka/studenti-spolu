<?php

namespace App\Http\Controllers;

use App\Intefaces\FileRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function show($id):RedirectResponse
    {
        if (Auth::check()) {
            $fileInfo = $this->files->getFileInfoById($id);
            if (count($fileInfo) == 1) {
                $destinationPath = storage_path() .'\app\uploads\\';
                $file_extension = $fileInfo[0]->type;
                $file = $destinationPath.basename($fileInfo[0]->unique_name.'.'.$file_extension);
                if (file_exists($file)) {
                    switch( $file_extension )
                    {
                        case "pdf": $ctype="application/pdf"; break;
                        case "txt": $ctype="application/txt"; break;
                        case "doc": $ctype="application/doc"; break;
                        case "xls": $ctype="application/vnd.ms-excel"; break;
                        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
                        case "gif": $ctype="image/gif"; break;
                        case "png": $ctype="image/png"; break;
                        case "jpeg":
                        case "jpg": $ctype="image/jpg"; break;
                        default: $ctype="application/octet-stream";
                    }
                    // Header content type
                    header("Content-type: $ctype");
                    header('Content-Disposition: inline; filename="' . $fileInfo[0]->name . '"');
                    header('Content-Transfer-Encoding: binary');
                    header('Content-Length: ' . filesize($file));
                    header('Accept-Ranges: bytes');
                    readfile($file);
                } else { //soubor neexistuje
                    return redirect()->route('index');
                }
            } else {
                abort(404, 'Soubor nenalezen');
            }
        } else {
            return redirect()->route('index');
        }
        return redirect()->route('index');
    }
}
