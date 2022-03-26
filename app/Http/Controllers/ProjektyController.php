<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjektyController extends Controller
{

    public function index()
    {
        return view('projekty/index',[]);
    }

    public function show($id)
    {
        return view('projekty/show', []);
    }

    public function create()
    {

    }

    public function edit()
    {

    }

    public function store()
    {

    }

    public function destroy()
    {

    }



}
