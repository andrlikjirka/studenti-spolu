<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestsCooperationController extends Controller
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

    public function store(Request $request, $id_offer)
    {


    }

    public function destroy()
    {

    }
}
