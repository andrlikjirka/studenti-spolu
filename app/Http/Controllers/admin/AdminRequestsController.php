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

    public function handle(Request $request, $id_request) {

    }

}
