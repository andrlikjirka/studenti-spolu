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

        $requests_recieved = DB::select('
            SELECT r.id_request as r_id_request, r.message as r_message, DATE(r.create_date) as r_create_date,
                   o.id_offer as o_id_offer, o.name as o_name, p.id_project as p_id_project, p.name as p_name,
                   u.id_user as u_id_user, u.first_name as u_first_name, u.last_name as u_last_name,
                   s.id_status as s_id_status, s.name as s_name, f.name as f_name
            FROM request_cooperation r, offer_cooperation o, project p, users u, field f, status_request s
            WHERE r.id_offer = o.id_offer
            AND   r.id_user = u.id_user
            AND   r.id_status = s.id_status
            AND   o.id_project = p.id_project
            AND   o.id_field = f.id_field
            AND   p.id_project IN (
                SELECT p.id_project FROM project p, cooperation c
                    WHERE p.id_project = c.id_project
                    AND   c.id_user = :id_user
                    AND   c.id_role = :id_role
                )
            ORDER BY r.create_date DESC;
        ', [
            ':id_user' => Auth::id(),
            ':id_role' => 1
        ]);

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
                ->with('requests_recieved', $requests_recieved)
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
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('edit_request_message', 'Úprava žádosti o spolupráci proběhla úspěšně.');
            } else {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('error_edit_request_message', 'Úprava žádosti o spolupráci selhala.');
            }
        } else if ($request->input('action') == 'delete-request-cooperation') {
            $result = $this->deleteRequestCooperation($request);
            if ($result == 1) {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('delete_request_message', 'Zrušení žádosti o spolupráci proběhlo úspěšně.');
            } else {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('error_delete_request_message', 'Zrušení žádosti o spolupráci selhalo.');
            }
        } else if ($request->input('action') == 'accept-request') {
            $result = $this->acceptRequestCooperation($request);
            if ($result == null) {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('accept_request_message', 'Přijetí žádosti o spolupráci proběhlo úspěšně. Máte nového spolupracovníka na projektu.');
            } else {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('error_accept_request_message', 'Přijetí žádosti o spolupráci selhalo.');
            }
        } else if ($request->input('action') == 'reject-request') {
            $result = $this->rejectRequestCooperation($request);
            if ($result == null) {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('reject_request_message', 'Zamítnutí žádosti o spolupráci proběhlo úspěšně.');
            } else {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('error_reject_request_message', 'Zamítnutí žádosti o spolupráci selhalo.');
            }
        } else if ($request->input('action') == 'waiting-request') {
            $result = $this->waitingRequestCooperation($request);
            if ($result == null) {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('waiting_request_message', 'Žádost o spolupráci byla úspěšně převedena ke znovuposouzení.');
            } else {
                return redirect()->route('zadosti-o-spolupraci.index')
                    ->with('error_waiting_request_message', 'Žádost o spolupráci nebyla úspěšně převedena ke znovuposouzení.');
            }
        }
        //default route
        return redirect()->route('zadosti-o-spolupraci.index');
    }

    private function editRequestCooperation(Request $request)
    {
        $request->validate([
            'edit-id-request' => 'required|integer',
            'edit-request-message' => 'required',
        ]);

        $id_request = $request->input('edit-id-request');
        $edit_request_message = $request->input('edit-request-message');

        $old_request = DB::select('
            SELECT * FROM request_cooperation WHERE id_request=:id_request;
        ', [':id_request' => $id_request]);

        if (strcmp($edit_request_message, $old_request[0]->message) !== 0) {
            $result = DB::update('
            UPDATE request_cooperation
                SET message = :message
                WHERE id_request = :id_request;
        ', [
                ':message' => $edit_request_message,
                ':id_request' => $id_request,
            ]);
        } else {
            $result = 1;
        }
        return $result;
    }

    private function deleteRequestCooperation(Request $request)
    {
        $request->validate([
            'delete-request-sent' => 'required|integer'
        ]);
        $id_request = $request->input('delete-request-sent');

        $result = DB::delete('
            DELETE FROM request_cooperation WHERE id_request = :id_request
        ', [':id_request' => $id_request]);
        return $result;
    }

    private function acceptRequestCooperation(Request $request)
    {
        $request->validate([
            'accept_id_request' => 'required|integer',
            'accept_id_user' => 'required|integer',
            'accept_id_project' => 'required|integer',
        ]);
        $id_request = $request->input('accept_id_request');
        $id_user = $request->input('accept_id_user');
        $id_project = $request->input('accept_id_project');

        $result = DB::transaction(function () use ($id_request, $id_project, $id_user) {
            DB::update('
            UPDATE request_cooperation
                SET id_status = :id_status
                WHERE id_request = :id_request;
            ', [
                ':id_status' => 2,
                ':id_request' => $id_request
            ]);
            DB::insert('
                INSERT INTO cooperation(id_user, id_project, id_role)
                VALUES (:id_user, :id_project, :id_role);
            ', [
                ':id_user' => $id_user,
                ':id_project' => $id_project,
                ':id_role' => 2
            ]);
        });
        return $result;
    }

    private function rejectRequestCooperation(Request $request)
    {
        $request->validate([
            'reject_id_request' => 'required|integer',
        ]);
        $id_request = $request->input('reject_id_request');

        $result = DB::transaction(function () use ($id_request) {
            DB::update('
            UPDATE request_cooperation
                SET id_status = :id_status
                WHERE id_request = :id_request;
            ', [
                ':id_status' => 3,
                ':id_request' => $id_request
            ]);
        });
        return $result;
    }

    private function waitingRequestCooperation(Request $request)
    {
        $request->validate([
            'waiting_id_request' => 'required|integer',
            'waiting_id_user' => 'required|integer',
            'waiting_id_project' => 'required|integer',
        ]);
        $id_request = $request->input('waiting_id_request');
        $id_user = $request->input('waiting_id_user');
        $id_project = $request->input('waiting_id_project');

        $result = DB::transaction(function () use ($id_request, $id_project, $id_user) {
            DB::update('
            UPDATE request_cooperation
                SET id_status = :id_status
                WHERE id_request = :id_request;
            ', [
                ':id_status' => 1,
                ':id_request' => $id_request
            ]);
            DB::insert('
                DELETE FROM cooperation
                WHERE id_user = :id_user AND id_project = :id_project AND id_role = :id_role
            ', [
                ':id_user' => $id_user,
                ':id_project' => $id_project,
                ':id_role' => 2
                ]);
        });
        return $result;
    }
}
