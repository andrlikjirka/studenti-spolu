<?php

namespace App\Http\Controllers;

use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\RequestCooperationRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro nabídky spolupráce
 */
class OffersCooperationController extends Controller
{
    /** @var OfferCooperationRepositoryInterface Atribut typu repository pro práci s nabídkami spolupráce */
    protected $offers;
    /** @var RequestCooperationRepositoryInterface Atribut typu repository pro práci se žádostmi o spolupráci */
    protected $requests;
    /** @var UserRepositoryInterface Atribut typu repository pro práci s uživateli */
    protected $users;

    /**
     * Konstruktor třídy
     * @param OfferCooperationRepositoryInterface $offers Rozhraní třídy pro práci s nabídkami spolupráce
     * @param RequestCooperationRepositoryInterface $requests Rozhraní třídy pro práci se žádostmi o spolupráci
     * @param UserRepositoryInterface $users Rozhraní třídy pro práci s uživateli
     */
    public function __construct(OfferCooperationRepositoryInterface $offers, RequestCooperationRepositoryInterface $requests,
                                UserRepositoryInterface $users,)
    {
        $this->offers = $offers;
        $this->requests = $requests;
        $this->users = $users;
    }

    /**
     * Metoda získá data o nabídkách spolupráce a předá je do šablony
     * @param Request $request HTTP požadavek
     * @return View View reprezentující šablonu pro nabídky spolupráce
     */
    public function index(Request $request)
    {
        $title = 'Nabídky spolupráce';

        if ($request->input('action') == 'match_offer' AND $request->input('match-checked') == true) {
            $offers = $this->offers->getMatchOffers();
            $request->session()->put('match', 'true');
        } else {
            $offers = $this->offers->getAllOffers();
            $request->session()->forget('match');
        }

        return view('nabidky-spoluprace/index')
            ->with('title', $title)
            ->with('offers', $offers);
    }

    /**
     * Metoda získá data o vybrané nabídce spolupráce a předá je šabloně
     * @param int $id_offer ID nabídky spolupráce
     * @return mixed View reprezentující šablonu pro detail nabídky spolupráce | 404 stránka
     */
    public function show($id_offer)
    {
        $offer_cooperation = $this->offers->getOfferById($id_offer);

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

    /**
     * Metoda slouží pro zpracováí formulářů na stránce nabídkek spolupráce
     * @param Request $request HTTP požadavek
     * @param int $id_offer ID nabídky spolupráce
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request, $id_offer): RedirectResponse
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

    /**
     * Metoda slouží pro odeslání žádosti o spolupráci
     * @param Request $request HTTP požadavek
     * @param int $id_offer ID nabídky spolupráce
     * @return mixed Výsledek vytvoření nové žádosti o spolupráci
     */
    private function new_request_cooperation(Request $request, $id_offer)
    {
        $request->validate([
            'request-message' => 'required',
            'request-id-user' => 'required',
        ]);

        $message = $this->testStringInput($request->input('request-message'));
        $id_user = $this->testIntegerInput($request->input('request-id-user'));
        $create_date = date("Y-m-d H:i:s");

        $result = $this->requests->createNewRequest($message, $create_date, $id_user, $id_offer);
        return $result;
    }

    /**
     * Metoda zjisti zda je přihlášený uživatel členem projektového týmu
     * @param int $id_project ID projektu
     * @return bool True pokud je uživatel členem týmu | False pokud uživatel není členem týmu
     */
    private function isUserTeamMember($id_project)
    {
        $id_user = Auth::id();
        $authUser_TeamMember = $this->users->getUserAsTeamMember($id_user, $id_project);
        if(count($authUser_TeamMember) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Metoda zjistí za přihlášený uživatel již odeslal žádost o spolupráci reagující na vybranou nabídku spolupráce
     * @param int $id_offer ID nabídky spolupráce
     * @return bool True pokud uživatel již odeslal žádost o spolupráci | False pokud uživatele ještě neodeslal žádost o spolupráci
     */
    private function userAlreadySentWaitingRequest($id_offer)
    {
        $id_user = Auth::id();
        $alreadySentWRequest = $this->requests->userAlreadySentWaitingRequestByOfferId($id_user, $id_offer);
        if (count($alreadySentWRequest) > 0) { //existuje odeslaná čakající žádost reagující na nabídku
            return true;
        } else {
            return false;
        }
    }

}
