<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\FileRepositoryInterface;
use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\StatusOfferRepositoryInterface;
use App\Intefaces\StatusProjectRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProjectsController extends Controller
{
    /**
     * @var ProjectRepositoryInterface
     */
    protected $projects;

    protected $users;

    protected $status_project;

    protected $offers;

    protected $status_offer;

    protected $files;

    protected $fields;

    public function __construct(ProjectRepositoryInterface          $projects, UserRepositoryInterface $users, StatusProjectRepositoryInterface $status_project,
                                OfferCooperationRepositoryInterface $offers, StatusOfferRepositoryInterface $status_offer,
                                FileRepositoryInterface             $files, FieldRepositoryInterface $fields)
    {
        $this->projects = $projects;
        $this->users = $users;
        $this->status_project = $status_project;
        $this->offers = $offers;
        $this->status_offer = $status_offer;
        $this->files = $files;
        $this->fields = $fields;
    }

    public function index()
    {
        $title = 'Administrace projektů';
        $projects = $this->projects->getAllProjects();

        return view('admin.projekty.index')
            ->with('title', $title)
            ->with('projects', $projects);
    }

    public function show($id)
    {
        $title = 'Úprava projektu';
        $project = $this->projects->getProjectById($id);;

        if (count($project) == 1) {
            $status_project_all = $this->status_project->getAllStatusProject();
            $team_members = $this->users->getTeamMembersByProjectId($id);
            $offers_cooperation = $this->offers->getOffersByProjectId($id);
            $files = $this->files->getFilesByProjectId($id);

            $fields_all = $this->fields->getAllFields();
            $status_offer_all = $this->status_offer->getAllStatusOffer();

            return view('admin.projekty.show')
                ->with('title', $title)
                ->with('project', $project[0])
                ->with('status_project_all', $status_project_all)
                ->with('files', $files)
                ->with('team_members', $team_members)
                ->with('offers_cooperation', $offers_cooperation)
                ->with('fields_all', $fields_all)
                ->with('status_offer_all', $status_offer_all);
        } else {
            return abort(404, 'Projekt nenalezen.'); //404 strana
        }
    }

    public function handle(Request $request, $id_project)
    {
        if ($request->input('action') == 'edit-project') {
            $this->editProject($request, $id_project);
            return redirect()->route('admin.projekty.show', $id_project)
                ->with('edit_project_message', 'Úprava projektu proběhla úspěšně.');
        } elseif ($request->input('action') == 'delete-project') {
            $this->projects->deleteProjectById($id_project);
            return redirect()->route('admin.projekty.index')->with('delete_project_message', 'Odstranění projektu proběhlo úspěšně.');
        } else if ($request->input('action') == 'delete-file') {
            $result = $this->deleteFile($request);
            if ($result == 1) {
                return redirect()->route('admin.projekty.show', $id_project)
                    ->with('delete-file-message', 'Smazání souboru proběhlo úspěšně.');
            } else {
                return redirect()->route('admin.projekty.show', $id_project)
                    ->with('error-delete-file-message', 'Smazání souboru selhalo.');
            }
        } else if ($request->input('action') == 'remove-team-member') {
            $result = $this->remove_team_member($request, $id_project);
            if ($result == 1) {
                return redirect()->route('admin.projekty.show', $id_project)
                    ->with('remove_team_member_message', 'Odebrání člena týmu proběhlo úspěšně.');
            } else {
                return redirect()->route('admin.projekty.show', $id_project)
                    ->with('error_remove_team_member_message', 'Odebrání člena týmu selhalo.');
            }
        } else if ($request->input('action') == 'remove-offer-cooperation') {
            $result = $this->remove_offer_cooperation($request, $id_project);
            if ($result == 1) {
                return redirect()->route('admin.projekty.show', $id_project)
                    ->with('remove-offer-cooperation-message', 'Smazání nabídky spolupráce proběhlo úspěšně.');
            } else {
                return redirect()->route('admin.projekty.show', $id_project)
                    ->with('error-remove-offer-cooperation-message', 'Smazání nabídky spolupráce selhalo.');
            }
        } else if ($request->input('action') == 'edit-offer-cooperation') {
            $result = $this->editOfferCooperation($request);
            return redirect()->route('admin.projekty.show', $id_project)
                ->with('edit-offer-cooperation-message', 'Úprava nabídky spolupráce proběhla úspěšně.');
        }
        //default route back
        return redirect()->route('admin.projekty.show', $id_project);
    }

    private function editProject(Request $request, $id_project)
    {
        $request->validate([
            'edit-name-project' => 'required|string|max:255',
            'edit-abstract-project' => 'required|string|max:255',
            'edit-description-project' => 'required',
            'edit-status-project' => 'required|integer|between:1,3',
        ]);

        $edit_name = $request->input('edit-name-project');
        $edit_abstract = $request->input('edit-abstract-project');
        $edit_description = $request->input('edit-description-project');
        $edit_status = $request->input('edit-status-project');

        $result = $this->projects->editProjectById($id_project, $edit_name, $edit_abstract, $edit_description, $edit_status);
        return $result;
    }

    private function deleteFile(Request $request)
    {
        $request->validate([
            'delete_id_file' => 'required|integer'
        ]);
        $delete_id_file = $request->input('delete_id_file');
        $fileInfo = $this->files->getFileInfoById($delete_id_file);
        $result = $this->files->deleteFile($delete_id_file);
        if ($result == 1) {
            $destinationPath = storage_path() . '\app\uploads\\';
            $target = $destinationPath . basename($fileInfo[0]->unique_name . '.' . $fileInfo[0]->type);
            unlink($target);
        }
        return $result;
    }

    private function remove_team_member(Request $request, $id_project)
    {
        $id_user = $request->input('remove_id_user');
        $result = $this->users->removeTeamMember($id_project, $id_user);
        return $result;
    }

    private function remove_offer_cooperation(Request $request, $id_project)
    {
        $request->validate([
            'remove_id_offer' => 'required|integer',
        ]);
        $remove_id_offer = $request->input('remove_id_offer');
        $result = $this->offers->removeOfferById($remove_id_offer);
        return $result;
    }

    private function editOfferCooperation(Request $request)
    {
        $request->validate([
            'edit-id-offer' => 'required|integer',
            'edit-name-offer-cooperation' => 'required|string|max:255',
            'edit-field-offer-cooperation' => 'required|integer',
            'edit-description-offer-cooperation' => 'required',
            'edit-status-offer-cooperation' => 'required|integer'
        ]);

        $edit_id_offer = $request->input('edit-id-offer');
        $edit_name_offer = $request->input('edit-name-offer-cooperation');
        $edit_description_offer = $request->input('edit-description-offer-cooperation');
        $edit_id_status_offer = $request->input('edit-status-offer-cooperation');
        $edit_id_field_offer = $request->input('edit-field-offer-cooperation');

        $result = $this->offers->editOfferById($edit_id_offer, $edit_name_offer, $edit_description_offer, $edit_id_field_offer, $edit_id_status_offer);
        return $result;
    }

}
