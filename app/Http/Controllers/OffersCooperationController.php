<?php

namespace App\Http\Controllers;

use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Repositories\OfferCooperationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OffersCooperationController extends Controller
{

    /**
     * @var OfferCooperationRepositoryInterface
     */
    protected $offers;

    public function __construct(OfferCooperationRepositoryInterface $offers)
    {
        $this->offers = $offers;
    }

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

        $result = $this->offers->createNewRequest($message, $create_date, $id_user, $id_offer);
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
