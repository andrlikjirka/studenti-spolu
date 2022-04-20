<?php

namespace App\Http\Controllers;

use App\Intefaces\FileRepositoryInterface;
use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro Projekty
 */
class ProjectsController extends Controller
{
    /** @var ProjectRepositoryInterface Atribut typu repository pro práci s projekty */
    protected $projects;
    /** @var OfferCooperationRepositoryInterface Atribut typu repository pro práci s nabídkami spolupráce */
    protected $offers;
    /** @var FileRepositoryInterface Atribut typu repository pro práci se soubory */
    protected $files;
    /** @var UserRepositoryInterface Atribut typu repository pro práci s uživateli */
    protected $users;

    /**
     * Konstruktor třídy
     * @param ProjectRepositoryInterface $projects Rozhraní třídy pro práci s projekty
     * @param OfferCooperationRepositoryInterface $offers Rozhraní třídy pro práci s nabídkami spolupráce
     * @param FileRepositoryInterface $files Rozhraní třídy pro práci se soubory
     * @param UserRepositoryInterface $users Rozhraní třídy pro práci s uživateli
     */
    public function __construct(ProjectRepositoryInterface $projects, OfferCooperationRepositoryInterface $offers,
                                FileRepositoryInterface $files, UserRepositoryInterface $users)
    {
        $this->projects = $projects;
        $this->offers = $offers;
        $this->files = $files;
        $this->users = $users;
    }

    /**
     * Metoda získá data o projektech a předá je šabloně
     * @param Request $request HTTP požadavek
     * @return View View reprezentující šablonu pro Projekty
     */
    public function index(Request $request): View
    {
        $title = 'Projekty';

        if ($request->input('action') == 'search-project') {
            $request->validate([
                'project_name' => 'nullable|string',
            ]);
            $project_name = $this->testStringInput($request->input('project_name')).'%';
            $projects = $this->projects->getSearchProjects($project_name);
        } else {
            $projects = $this->projects->getAllProjects();
        }

        return view('projekty/index')
            ->with('title', $title)
            ->with('projects', $projects);
    }

    /**
     * Metoda získá data o vybraném projektu a předá je šabloně
     * @param int $id_project ID projektu
     * @return mixed View reprezentující šablonu pro detail projektu | 404 stránka
     */
    public function show($id_project): mixed
    {
        $project = $this->projects->getProjectById($id_project);
        $team_members = $this->users->getTeamMembersByProjectId($id_project);
        $project_offers_cooperation = $this->offers->getActiveOffersByProjectId($id_project);
        $files = $this->files->getFilesByProjectId($id_project);

        if(count($project) == 1) {
            return view('projekty.show')
                ->with('project', $project[0]) //$project je pole s jednim prvkem = ziskany projekt => chci primo ziskane pole, proto [0]
                ->with('files', $files)
                ->with('team_members', $team_members)
                ->with('project_offers', $project_offers_cooperation);
        } else {
            return abort(404, 'Projekt nenalezen.'); //404 strana
        }
    }

}
