<?php

namespace App\Http\Controllers;

use App\Intefaces\FileRepositoryInterface;
use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    /**
     * @var ProjectRepositoryInterface
     */
    protected $projects;

    protected $offers;

    protected $files;

    protected $users;

    public function __construct(ProjectRepositoryInterface $projects, OfferCooperationRepositoryInterface $offers,
                                FileRepositoryInterface $files, UserRepositoryInterface $users)
    {
        $this->projects = $projects;
        $this->offers = $offers;
        $this->files = $files;
        $this->users = $users;
    }

    public function index(Request $request)
    {
        $title = 'Projekty';

        if ($request->input('action') == 'search-project') {
            $request->validate([
                'project_name' => 'nullable|string',
            ]);
            $project_name = htmlspecialchars($request->input('project_name')).'%';
            $projects = $this->projects->getSearchProjects($project_name);
        } else {
            $projects = $this->projects->getAllProjects();
        }

        return view('projekty/index')
            ->with('title', $title)
            ->with('projects', $projects);
    }

    public function show($id_project)
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
