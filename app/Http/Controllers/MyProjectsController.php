<?php

namespace App\Http\Controllers;

use App\Intefaces\FieldRepositoryInterface;
use App\Intefaces\FileRepositoryInterface;
use App\Intefaces\OfferCooperationRepositoryInterface;
use App\Intefaces\ProjectRepositoryInterface;
use App\Intefaces\StatusOfferRepositoryInterface;
use App\Intefaces\StatusProjectRepositoryInterface;
use App\Intefaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;


class MyProjectsController extends Controller
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

    public function __construct(ProjectRepositoryInterface $projects, UserRepositoryInterface $users, StatusProjectRepositoryInterface $status_project,
                                OfferCooperationRepositoryInterface $offers, StatusOfferRepositoryInterface $status_offer,
                                FileRepositoryInterface $files, FieldRepositoryInterface $fields)
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
        $title = 'Moje projekty';
        $logged_user_id = Auth::id();

        //autorské projekty
        $projects_author = $this->projects->getProjectsByUserId($logged_user_id, 1);

        //spolupracovnické projekty
        $projects_collab = $this->projects->getProjectsByUserId($logged_user_id, 2);

        return view('moje-projekty.index')
            ->with('title', $title)
            ->with('projects_author', $projects_author)
            ->with('projects_collab', $projects_collab);
    }

    public function show($id)
    {
        $title = 'Úprava projektu';
        $logged_user_id = Auth::id();
        $my_project = $this->projects->getProjectById($id);;

        if (count($my_project) == 1) {
            $status_project_all = $this->status_project->getAllStatusProject();
            $team_members = $this->users->getTeamMembersByProjectId($id);
            $offers_cooperation = $this->offers->getOffersByProjectId($id);
            $files = $this->files->getFilesByProjectId($id);

            $fields_all = $this->fields->getAllFields();
            $status_offer_all = $this->status_offer->getAllStatusOffer();

            return view('moje-projekty.show')
                ->with('title', $title)
                ->with('my_project', $my_project[0])
                ->with('status_project_all', $status_project_all)
                ->with('files', $files)
                ->with('team_members', $team_members)
                ->with('offers_cooperation', $offers_cooperation)
                ->with('fields_all', $fields_all)
                ->with('status_offer_all', $status_offer_all);
        } else {
            return abort(404, 'Můj projekt nenalezen.'); //404 strana
        }

    }

    public function update(Request $request, $id)
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

        $result = $this->projects->editProjectById($id, $edit_name, $edit_abstract, $edit_description, $edit_status);

        return redirect()->route('moje-projekty.show', $id)
            ->with('edit_project_message', 'Úprava projektu proběhla úspěšně.');
    }

    public function store(Request $request)
    {
        $logged_user_id = Auth::id();

        $request->validate([
            'new-name-project' => 'required|string|max:255',
            'new-abstract-project' => 'string|max:255',
            'new-description-project' => 'required',
        ]);

        $name = $request->input('new-name-project');
        $abstract = $request->input('new-abstract-project');
        $description = $request->input('new-description-project');
        $create_date = date("Y-m-d H:i:s");

        $result = $this->projects->createNewProject($logged_user_id, $name, $abstract, $description, $create_date);
        if ($result == null) {
            return redirect()->route('moje-projekty.index')->with('new_project_message', 'Vytvoření a zveřejnění nového projektu proběhlo úspěšně.');
        } else {
            return redirect()->route('moje-projekty.index')->with('error_new_project_message', 'Vytvoření a zveřejnění nového projektu selhalo.');
        }
    }

    public function destroy(Request $request)
    {
        $delete_project_id = $request->input('delete_id_project');
        $this->projects->deleteProjectById($delete_project_id);
        return redirect()->route('moje-projekty.index')->with('delete_project_message', 'Odstranění projektu proběhlo úspěšně.');
    }

    // funkce pro zpracovani doplnujicich formularu na strance detailu mého projektu
    public function handle(Request $request, $id_project)
    {
        if ($request->input('action') == 'file-upload') {
            $result = $this->file_upload($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('file-upload-message', 'Nahrání souboru proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-file-upload-message', 'Nahrání souboru selhalo.');
            }
        } else if ($request->input('action') == 'delete-file') {
            $result = $this->deleteFile($request);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                ->with('delete-file-message', 'Smazání souboru proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-delete-file-message', 'Smazání souboru selhalo.');
            }
        } else if ($request->input('action') == 'remove-team-member') {
            $result = $this->remove_team_member($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('remove_team_member_message', 'Odebrání člena týmu proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error_remove_team_member_message', 'Odebrání člena týmu selhalo.');
            }
        } else if ($request->input('action') == 'new-offer-cooperation') {
            $result = $this->new_cooperation_offer($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('new-offer-cooperation-message', 'Vytvoření a zveřejnění nové nabídky spolupráce proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-new-offer-cooperation-message', 'Vytvoření a zveřejnění nové nabídky spolupráce selhalo.');
            }
        } else if ($request->input('action') == 'remove-offer-cooperation') {
            $result = $this->remove_offer_cooperation($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('remove-offer-cooperation-message', 'Smazání nabídky spolupráce proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-remove-offer-cooperation-message', 'Smazání nabídky spolupráce selhalo.');
            }
        } else if ($request->input('action') == 'edit-offer-cooperation') {
            $result = $this->edit_offer_cooperation($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('edit-offer-cooperation-message', 'Úprava nabídky spolupráce proběhla úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-edit-offer-cooperation-message', 'Úprava nabídky spolupráce selhala.');
            }
        }
        //default route back
        return redirect()->route('moje-projekty.show', $id_project);
    }

    private function remove_team_member(Request $request, $id_project)
    {
        $id_user = $request->input('remove_id_user');
        $result = $this->users->removeTeamMember($id_project, $id_user);
        return $result;
    }

    private function new_cooperation_offer(Request $request, $id_project)
    {
        $request->validate([
            'name-offer-cooperation' => 'required|string|max:255',
            'field-offer-cooperation' => 'required|integer',
            'description-offer-cooperation' => 'required',
        ]);

        $name = $request->input('name-offer-cooperation');
        $id_field = $request->input('field-offer-cooperation');
        $description = $request->input('description-offer-cooperation');
        $create_date = date("Y-m-d H:i:s");

        $result = $this->offers->createNewOffer($name, $description, $create_date, $id_field, $id_project);
        return $result;
    }

    private function edit_offer_cooperation(Request $request, $id_project)
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

    private function remove_offer_cooperation(Request $request, $id_project)
    {
        $request->validate([
            'remove_id_offer' => 'required|integer',
        ]);
        $remove_id_offer = $request->input('remove_id_offer');
        $result = $this->offers->removeOfferById($remove_id_offer);
        return $result;
    }

    private function file_upload(Request $request, $id_project)
    {
        $request->validate([
            'id_user' => 'required|integer'
        ]);
        $id_user = $request->input('id_user');
        $file = $request->file('uploadFile');
        $originalName = $file->getClientOriginalName();
        $type = $file->getClientOriginalExtension();
        $uploadDate = date('Y-m-d G:i:s');
        $uploadDateTime = date("Y-m-d") . "_" . time();
        $uniqueName = $id_user.'_'.$id_project.'_'.$uploadDateTime;
        $destinationPath = storage_path() .'\app\uploads\\';
        $target = $destinationPath.basename($uniqueName.'.'.$type);
        $result = $this->files->uploadFile($id_project, $originalName, $uniqueName, $type, $uploadDate);
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target);
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
            $destinationPath = storage_path() .'\app\uploads\\';
            $target = $destinationPath.basename($fileInfo[0]->unique_name.'.'.$fileInfo[0]->type);
            unlink($target);
        }
        return $result;
    }


}
