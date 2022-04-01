<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestsCooperationController extends Controller
{
    public function index()
    {
        $title = "Žádosti o spolupráci";

        $requests = 0;

        $requests_sent = DB::select('
            SELECT r.id_request as r_id_request, r.message as r_message, DATE(r.create_date) as r_create_date,
                o.id_offer as o_id_offer, o.name as o_name, p.id_project as p_id_project,
                p.name as p_name, f.name as f_name, s.id_status as s_id_status, s.name as s_name
            FROM request_cooperation r, offer_cooperation o, status_request s, project p, field f
                WHERE r.id_offer = o.id_offer
                AND   o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   r.id_status = s.id_status
                AND   id_user = :id_user
            ORDER BY r.create_date DESC;
        ', [
            ':id_user' => Auth::id(),
        ]);

        return view('zadosti.index')
                ->with('title', $title)
                ->with('requests_sent', $requests_sent);

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

    public function handle(Request $request)
    {
        if ($request->input('action') == 'edit-request-cooperation') {
            $result = $this->editRequestCooperation($request);
            if ($result == 1) {
                return redirect()->route('zadosti.index')
                    ->with('edit_request_message', 'Úprava žádosti o spolupráci proběhla úspěšně.');
            } else {
                return redirect()->route('zadosti.index')
                    ->with('error_edit_request_message', 'Úprava žádosti o spolupráci selhala.');
            }
        } else if ($request->input('action') == 'delete-request-cooperation') {
            $result = $this->deleteRequestCooperation($request);
            if ($result == 1) {
                return redirect()->route('zadosti.index')
                    ->with('delete_request_message', 'Zrušení žádosti o spolupráci proběhlo úspěšně.');
            } else {
                return redirect()->route('zadosti.index')
                    ->with('error_delete_request_message', 'Zrušení žádosti o spolupráci selhalo.');
            }
        }
        //default route
        return redirect()->route('zadosti.index');
    }

    private function editRequestCooperation(Request $request)
    {
        $request->validate([
            'edit-request-message' => 'required',
        ]);

        $id_request = $request->input('edit-id-request');
        $edit_request_message = $request->input('edit-request-message');

        $result = DB::update('
            UPDATE request_cooperation
                SET message = :message
                WHERE id_request = :id_request;
        ', [
            ':message' => $edit_request_message,
            ':id_request' => $id_request,
        ]);
        return $result;
    }

    private function deleteRequestCooperation(Request $request)
    {
        $id_request = $request->input('delete-request-sent');

        $result = DB::delete('
            DELETE FROM request_cooperation WHERE id_request = :id_request
        ', [':id_request' => $id_request]);
        return $result;
    }
}
