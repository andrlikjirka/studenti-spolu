<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MojeProjektyController extends Controller
{
    public function index()
    {
        return view('moje-projekty.index',[]);
    }

    public function show($id)
    {
        return view('moje-projekty.show', []);
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
