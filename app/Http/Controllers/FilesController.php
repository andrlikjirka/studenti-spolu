<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{

    public function show(Request $request, $id)
    {
        if (Auth::check()) {
            $fileInfo = DB::select('SELECT * FROM file WHERE id_file=:id_file', [':id_file' => $id]);
            $destinationPath = storage_path() .'\app\uploads\\';
            $file = $destinationPath.basename($fileInfo[0]->unique_name.'.'.$fileInfo[0]->type);
            if (file_exists($file)) {
                // Header content type
                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="' . $file . '"');
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . filesize($file));
                header('Accept-Ranges: bytes');
                readfile($file);
            } else { //soubor neexistuje
                return redirect()->route('index');
            }
        } else {
            return redirect()->route('index');
        }
        return redirect()->route('index');
    }
}
