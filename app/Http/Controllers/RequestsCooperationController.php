<?php

namespace App\Http\Controllers;

use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\RequestCooperationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequestsCooperationController extends Controller
{
    protected $requests;

    public function __construct(RequestCooperationRepositoryInterface $requests)
    {
        $this->requests = $requests;
    }

    public function index()
    {
        $title = "Žádosti o spolupráci";
        $id_user = Auth::id();
        $requests_recieved = $this->requests->getAllRecievedRequests($id_user);
        $requests_sent = $this->requests->getAllSentRequests($id_user);
        return view('zadosti.index')
                ->with('title', $title)
                ->with('requests_recieved', $requests_recieved)
                ->with('requests_sent', $requests_sent);
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

        $old_request = $this->requests->getOldRequestBeforeEdit($id_request);
        if (strcmp($edit_request_message, $old_request[0]->message) !== 0) {
            $result = $this->requests->editRequestById($id_request, $edit_request_message);
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
        $result = $this->requests->deleteRequestById($id_request);
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

        $result = $this->requests->acceptRequestById($id_request, $id_project, $id_user);
        return $result;
    }

    private function rejectRequestCooperation(Request $request)
    {
        $request->validate([
            'reject_id_request' => 'required|integer',
        ]);
        $id_request = $request->input('reject_id_request');

        $result = $this->requests->rejectRequestById($id_request);
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

        $result = $this->requests->setWaitingRequestById($id_request, $id_project, $id_user);
        return $result;
    }
}
