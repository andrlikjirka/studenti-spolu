<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Třída reprezentující kontroller, který je předkem všech konkrétních implementovaných kontrollerů
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Metoda slouží pro ošetření textového vstupu
     * @param $input mixed Textový vstup z požadavku
     * @return int Ošetřený textová vstup
     */
    protected function testStringInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    /**
     * Metoda slouží pro ošetření číselného vstupu
     * @param $input mixed Číselný vstup z požadavku
     * @return int Ošetřený číselný vstup
     */
    protected function testIntegerInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = intval($input);
        return $input;
    }
}
