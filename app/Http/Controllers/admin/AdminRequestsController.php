<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\FileRepositoryInterface;
use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\RequestCooperationRepositoryInterface;
use App\Intefaces\StatusOfferRepositoryInterface;
use App\Intefaces\StatusProjectRepositoryInterface;
use App\Intefaces\StatusRequestRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class AdminRequestsController extends Controller
{

    protected $requests;

    protected $status_request;

    public function __construct(RequestCooperationRepositoryInterface $requests, StatusRequestRepositoryInterface $status_request)
    {
        $this->requests = $requests;
        $this->status_request = $status_request;
    }

    public function index()
    {
        $title = 'Administrace žádostí o spolupráci';
        $requests = $this->requests->getAllRequests();


        return view('admin.zadosti.index')
            ->with('title', $title)
            ->with('requests', $requests);
    }

    public function show($id_request)
    {
        $title = 'Úprava žádosti o spolupráci';
        $request = $this->requests->getRequestById($id_request);
        if (count($request) == 1) {
            $status_request_all = $this->status_request->getAllStatusRequest();

            return view('admin.zadosti.show')
                ->with('title', $title)
                ->with('request', $request[0])
                ->with('status_request_all', $status_request_all);
        } else {
            return abort(404, 'Žádost o spolupráci nenalezena.'); //404 strana
        }
    }

    public function handle(Request $request, $id_request)
    {
        if ($request->input('action') === 'edit-request') {
            $result = $this->editRequest($request, $id_request);
            if ($result == 1) {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('edit_request_message', 'Úprava žádosti o spolupráci proběhla úspěšně.');
            } else {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('error_edit_request_message', 'Úprava žádosti o spolupráci selhala.');
            }
        } elseif($request->input('action') === 'delete-request') {
            $result = $this->requests->deleteRequestById($id_request);
            if ($result == 1) {
                return redirect()->route('admin.zadosti.index')
                    ->with('delete_request_message', 'Zrušení žádosti o spolupráci proběhlo úspěšně.');
            } else {
                return redirect()->route('admin.zadosti.index')
                    ->with('error_delete_request_message', 'Zrušení žádosti o spolupráci selhalo.');
            }
        } else if ($request->input('action') == 'accept-request') {
            $result = $this->acceptRequestCooperation($request, $id_request);
            if ($result == null) {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('accept_request_message', 'Přijetí žádosti o spolupráci proběhlo úspěšně.');
            } else {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('error_accept_request_message', 'Přijetí žádosti o spolupráci selhalo.');
            }
        } else if ($request->input('action') == 'reject-request') {
            $result = $this->requests->rejectRequestById($id_request);
            if ($result == null) {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('reject_request_message', 'Zamítnutí žádosti o spolupráci proběhlo úspěšně.');
            } else {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('error_reject_request_message', 'Zamítnutí žádosti o spolupráci selhalo.');
            }
        } else if ($request->input('action') == 'waiting-request') {
            $result = $this->waitingRequestCooperation($request, $id_request);
            if ($result == null) {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('waiting_request_message', 'Žádost o spolupráci byla úspěšně převedena ke znovuposouzení.');
            } else {
                return redirect()->route('admin.zadosti.show', $id_request)
                    ->with('error_waiting_request_message', 'Žádost o spolupráci nebyla úspěšně převedena ke znovuposouzení.');
            }
        }
        //default route
        return redirect()->route('admin.zadosti.index');
    }

    private function editRequest(Request $request, $id_request)
    {
        $request->validate([
            'edit-request-message' => 'required',
        ]);
        $edit_request_message = $request->input('edit-request-message');
        $old_request = $this->requests->getOldRequestBeforeEdit($id_request);
        if (strcmp($edit_request_message, $old_request[0]->message) !== 0) {
            $result = $this->requests->editRequestById($id_request, $edit_request_message);
        }
        else {
            $result = 1;
        }
        return $result;
    }

    private function acceptRequestCooperation(Request $request, $id_request)
    {
        $request->validate([
            'accept_id_user' => 'required|integer',
            'accept_id_project' => 'required|integer',
        ]);
        $id_user = $request->input('accept_id_user');
        $id_project = $request->input('accept_id_project');

        $result = $this->requests->acceptRequestById($id_request, $id_project, $id_user);
        return $result;
    }

    private function waitingRequestCooperation(Request $request, $id_request)
    {
        $request->validate([
            'waiting_id_user' => 'required|integer',
            'waiting_id_project' => 'required|integer',
        ]);
        $id_user = $request->input('waiting_id_user');
        $id_project = $request->input('waiting_id_project');

        $result = $this->requests->setWaitingRequestById($id_request, $id_project, $id_user);
        return $result;
    }

}
