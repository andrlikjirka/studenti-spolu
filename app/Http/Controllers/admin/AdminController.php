<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $title = 'Administrace aplikace';
        return view('admin.index')
            ->with('title', $title);
    }
}
