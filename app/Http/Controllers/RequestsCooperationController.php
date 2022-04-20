<?php

namespace App\Http\Controllers;

use App\Intefaces\RequestCooperationRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro žádosti o spolupráci
 */
class RequestsCooperationController extends Controller
{
    /** @var RequestCooperationRepositoryInterface Atribut typu repository pro práci se žádostmi o spolupráci */
    protected $requests;

    /**
     * Konstruktor třídy
     * @param RequestCooperationRepositoryInterface $requests Rozhraní třídy pro práci se žádostmi o spolupráci
     */
    public function __construct(RequestCooperationRepositoryInterface $requests)
    {
        $this->requests = $requests;
    }

    /**
     * Metoda získá data o žádostech o spolupráci a předá je šabloně
     * @return View View reprezentující šablonu pro žádosti o spolupráci
     */
    public function index(): View
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

    /**
     * Metoda slouží pro zpracování formulářů
     * @param Request $request HTTP požadavek
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request): RedirectResponse
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

    /**
     * Metoda slouží pro úpravu žádosti o spolupráci
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek úpravy žádosti o spolupráci
     */
    private function editRequestCooperation(Request $request): mixed
    {
        $request->validate([
            'edit-id-request' => 'required|integer',
            'edit-request-message' => 'required',
        ]);

        $id_request = $this->testIntegerInput($request->input('edit-id-request'));
        $edit_request_message = $this->testStringInput($request->input('edit-request-message'));

        $old_request = $this->requests->getOldRequestBeforeEdit($id_request);
        if (strcmp($edit_request_message, $old_request[0]->message) !== 0) {
            $result = $this->requests->editRequestById($id_request, $edit_request_message);
        } else {
            $result = 1;
        }
        return $result;
    }

    /**
     * Metoda slouží ke zrušení odeslané žádosti o spolupráci
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek zrušení žádosti o spolupráci
     */
    private function deleteRequestCooperation(Request $request): mixed
    {
        $request->validate([
            'delete-request-sent' => 'required|integer'
        ]);
        $id_request = $this->testIntegerInput($request->input('delete-request-sent'));
        $result = $this->requests->deleteRequestById($id_request);
        return $result;
    }

    /**
     * Metoda slouží pro schválení přijaté žádosti o spolupráci
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek schválení přijaté žádosti o spolupráci
     */
    private function acceptRequestCooperation(Request $request): mixed
    {
        $request->validate([
            'accept_id_request' => 'required|integer',
            'accept_id_user' => 'required|integer',
            'accept_id_project' => 'required|integer',
        ]);
        $id_request = $this->testIntegerInput($request->input('accept_id_request'));
        $id_user = $this->testIntegerInput($request->input('accept_id_user'));
        $id_project = $this->testIntegerInput($request->input('accept_id_project'));

        $result = $this->requests->acceptRequestById($id_request, $id_project, $id_user);
        return $result;
    }

    /**
     * Metoda slouží pro zamítnutí přijaté žádosti o spolupráci
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek zamítnutí přijaté žádosti o spolupráci
     */
    private function rejectRequestCooperation(Request $request)
    {
        $request->validate([
            'reject_id_request' => 'required|integer',
        ]);
        $id_request = $this->testIntegerInput($request->input('reject_id_request'));

        $result = $this->requests->rejectRequestById($id_request);
        return $result;
    }

    /**
     * Metoda slouží pro znovuposouzení žádosti o spolupráci
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek znovuposouzení žádosti o spolupráci
     */
    private function waitingRequestCooperation(Request $request)
    {
        $request->validate([
            'waiting_id_request' => 'required|integer',
            'waiting_id_user' => 'required|integer',
            'waiting_id_project' => 'required|integer',
        ]);
        $id_request = $this->testIntegerInput($request->input('waiting_id_request'));
        $id_user = $this->testIntegerInput($request->input('waiting_id_user'));
        $id_project = $this->testIntegerInput($request->input('waiting_id_project'));

        $result = $this->requests->setWaitingRequestById($id_request, $id_project, $id_user);
        return $result;
    }
}
