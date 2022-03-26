<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UzivateleController extends Controller
{
    public function index()
    {
        return view('uzivatele/index', []);
    }

    public function show($id)
    {
        return view('uzivatele.show', []);
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
