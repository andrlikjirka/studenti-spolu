<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ZadostiController extends Controller
{
    public function index()
    {
        return view('zadosti.index',[]);
    }

    public function show($id)
    {
        return view('zadosti.show', []);
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
