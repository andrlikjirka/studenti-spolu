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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;

/**
 * Třída reprezentující kontroller pro administraci žádostí o spolupráci
 */
class AdminRequestsController extends Controller
{
    /** @var RequestCooperationRepositoryInterface Atribut typu repository pro práci se žádostmi o spolupráci */
    protected $requests;
    /** @var StatusRequestRepositoryInterface Atribut typu repository pro práci se stavy žádostí o spolupráci */
    protected $status_request;

    /**
     * Konstruktor třídy
     * @param RequestCooperationRepositoryInterface $requests Rozhraní třídy pro práci se žádostmi o spolupráci
     * @param StatusRequestRepositoryInterface $status_request Rozhraní třídy pro práci se stavy žádostí o spolupráci
     */
    public function __construct(RequestCooperationRepositoryInterface $requests, StatusRequestRepositoryInterface $status_request)
    {
        $this->requests = $requests;
        $this->status_request = $status_request;
    }

    /**
     * Metoda získá data všech žádostí o spolupráci a předá je šabloně
     * @return View Šablona pro stránku administrace žádostí o spolupráci
     */
    public function index():View
    {
        $title = 'Administrace žádostí o spolupráci';
        $requests = $this->requests->getAllRequests();

        return view('admin.zadosti.index')
            ->with('title', $title)
            ->with('requests', $requests);
    }

    /**
     * Metoda získá příslušná data o vybrané žádosti o spolupráci a předá je šabloně
     * @param $id_request int ID vybrané žádosti o spolupráci
     * @return mixed View reprezentující šablonu pro administraci žádostí | stránka 404
     */
    public function show($id_request):mixed
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

    /**
     * Metoda slouží pro zpracování formulářů na stránkách pro administraci žádostí o spolupráci
     * @param Request $request HTTP požadavek
     * @param $id_request int ID vybrané žádosti o spolupráci
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request, $id_request): RedirectResponse
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

    /**
     * Metoda slouží pro získání dat z formuláře a úpravu projektu
     * @param Request $request HTTP požadavek
     * @param $id_request int ID vybrané žádosti o spolupráci
     * @return int Výsledek úpravy žádosti o spolupráci
     */
    private function editRequest(Request $request, $id_request): int
    {
        $request->validate([
            'edit-request-message' => 'required',
        ]);
        $edit_request_message = $this->testStringInput($request->input('edit-request-message'));
        $old_request = $this->requests->getOldRequestBeforeEdit($id_request);
        if (strcmp($edit_request_message, $old_request[0]->message) !== 0) {
            $result = $this->requests->editRequestById($id_request, $edit_request_message);
        }
        else {
            $result = 1;
        }
        return $result;
    }

    /**
     * Metoda slouží pro schválení žádosti o spolupráce
     * @param Request $request HTTP požadavek
     * @param $id_request int ID žádosti o spolupráci
     * @return mixed Výsledek schválení žádosti o spolupráci
     */
    private function acceptRequestCooperation(Request $request, $id_request)
    {
        $request->validate([
            'accept_id_user' => 'required|integer',
            'accept_id_project' => 'required|integer',
        ]);
        $id_user = $this->testIntegerInput($request->input('accept_id_user'));
        $id_project = $this->testIntegerInput($request->input('accept_id_project'));

        $result = $this->requests->acceptRequestById($id_request, $id_project, $id_user);
        return $result;
    }

    /**
     * Metoda slouží pro převod žádosti o spolupráci do stavu Čeká na vyřízení
     * @param Request $request HTTP požadavek
     * @param $id_request int ID žádosti o spolupráci
     * @return mixed Výsledek znovuposouzení žádosti o spolupráci
     */
    private function waitingRequestCooperation(Request $request, $id_request)
    {
        $request->validate([
            'waiting_id_user' => 'required|integer',
            'waiting_id_project' => 'required|integer',
        ]);
        $id_user = $this->testIntegerInput($request->input('waiting_id_user'));
        $id_project = $this->testIntegerInput($request->input('waiting_id_project'));

        $result = $this->requests->setWaitingRequestById($id_request, $id_project, $id_user);
        return $result;
    }

}
