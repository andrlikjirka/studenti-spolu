<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffersCooperationController extends Controller
{


    public function index(Request $request)
    {
        $title = 'Nabídky spolupráce';

        if ($request->input('action') == 'match_offer' AND $request->input('match-checked') == true) {
            $offers = DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
                DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   s.id_status = :id_status
                AND   f.id_field IN (
                    SELECT u.id_field FROM users_field u
                        WHERE u.id_user = :id_user
                )
                ORDER BY o.create_date DESC;
        ', [':id_status' => 1,':id_user' => Auth::id() ]);
            $request->session()->put('match', 'true');
        } else {
            $offers = DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
                DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, project p, field f, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   s.id_status = :id_status
                ORDER BY o.create_date DESC;
        ', [':id_status' => 1]);
            $request->session()->forget('match');
        }

        return view('nabidky-spoluprace/index')
            ->with('title', $title)
            ->with('offers', $offers);
    }

    public function show($id_offer)
    {
        $offer_cooperation = DB::select('
            SELECT p.id_project as p_id_project, p.name as p_name, o.id_offer as o_id_offer,o.name as o_name, o.description as o_description,
                DATE(o.create_date) as o_create_date, f.id_field as f_id_field,f.name as f_name,
                s.id_status as s_id_status, s.name as s_name
            FROM offer_cooperation o, field f, project p, status_offer s
                WHERE o.id_project = p.id_project
                AND   o.id_field = f.id_field
                AND   o.id_status = s.id_status
                AND   s.id_status = :id_status
                AND   o.id_offer = :id_offer;
            ', [
                ':id_status' => 1,
                ':id_offer' => $id_offer,
            ]);

        if (count($offer_cooperation) == 1) {
            $isUser_TeamMember = $this->isUserTeamMember($offer_cooperation[0]->p_id_project);
            $userAlreadySentWRequest = $this->userAlreadySentWaitingRequest($id_offer);

            return view('nabidky-spoluprace.show')
                ->with('offer_cooperation', $offer_cooperation[0]) //$offer_cooperation je pole s jednim prvkem = ziskana nabidka => chci primo ziskany prvek, proto [0]
                ->with('isUser_TeamMember', $isUser_TeamMember)
                ->with('userAlreadySentWRequest', $userAlreadySentWRequest);
        } else {
            return abort(404, 'Nabídka spolupráce nenalezena.'); //404 strana
        }
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

    public function handle(Request $request, $id_offer)
    {
        if ($request->input('action') == 'new-request-cooperation') {
            $result = $this->new_request_cooperation($request, $id_offer);
            if ($result == true) {
                return redirect()->route('nabidky-spoluprace.show', $id_offer)
                    ->with('new-request-cooperation-message', 'Odeslání žádosti o spolupráci proběhlo úspěšně.');
            } else {
                return redirect()->route('nabidky-spoluprace.show', $id_offer)
                    ->with('error-new-request-cooperation-message', 'Odeslání žádosti o spolupráci selhalo.');
            }
        }
        return redirect()->route('nabidky-spoluprace.index');
    }

    private function new_request_cooperation(Request $request, $id_offer)
    {
        $request->validate([
            'request-message' => 'required',
            'request-id-user' => 'required',
        ]);

        $message = $request->input('request-message');
        $id_user = $request->input('request-id-user');
        $create_date = date("Y-m-d H:i:s");

        $result = DB::insert('
            INSERT INTO request_cooperation (message, create_date, id_user, id_offer, id_status)
            VALUES (:message, :create_date, :id_user, :id_offer, :id_status);
        ', [
            ':message' => $message,
            ':create_date' => $create_date,
            ':id_user' => $id_user,
            ':id_offer' => $id_offer,
            ':id_status' => 1,
        ]);

        return $result;
    }

    private function isUserTeamMember($id_project)
    {
        $authUser_TeamMember = DB::select('
            SELECT c.id_role
            FROM project p, cooperation c
            WHERE p.id_project = c.id_project
            AND p.id_project = :id_project
            AND c.id_user = :id_user;
        ', [
            ':id_project' => $id_project,
            ':id_user' => Auth::id()
        ]);

        if(count($authUser_TeamMember) > 0) {
            return true;
        } else {
            return false;
        }

    }

    private function userAlreadySentWaitingRequest($id_offer)
    {
        $alreadySentWRequest = DB::select('
        SELECT id_request FROM request_cooperation
        WHERE id_user = :id_user
        AND   id_status = :id_status
        AND   id_offer = :id_offer;
        ', [
            ':id_user' => Auth::id(),
            ':id_status' => 1, //čekající na vyřízení
            ':id_offer' => $id_offer
        ]);

        if (count($alreadySentWRequest) > 0) { //existuje odeslaná čakající žádost reagující na nabídku
            return true;
        } else {
            return false;
        }
    }

}
