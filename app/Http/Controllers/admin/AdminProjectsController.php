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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;

/**
 * Třída reprezentujcí kontroller pro administraci projektů
 */
class AdminProjectsController extends Controller
{
    /** @var ProjectRepositoryInterface Atribut typu repository pro práci s projekty */
    protected $projects;
    /** @var UserRepositoryInterface Atribut typu repository pro práci s uživateli */
    protected $users;
    /** @var StatusProjectRepositoryInterface Atribut typu repository pro práci se stavy projektů */
    protected $status_project;
    /** @var OfferCooperationRepositoryInterface Atribut typu repositry pro práci s nabídkami spolupráce */
    protected $offers;
    /** @var StatusOfferRepositoryInterface Atribut typu repository pro práci se stavy nabídek spolupráce */
    protected $status_offer;
    /** @var FileRepositoryInterface Atribut typu repository pro práci se soubory */
    protected $files;
    /** @var FieldRepositoryInterface Atribut typu repository pro práci s obory */
    protected $fields;

    /**
     * Konstruktor třídy
     * @param ProjectRepositoryInterface $projects Rozhraní třídy pro práci s projekty
     * @param UserRepositoryInterface $users Rozhraní třídy pro práci s uživateli
     * @param StatusProjectRepositoryInterface $status_project Rozhraní třídy pro práci se stavy projektů
     * @param OfferCooperationRepositoryInterface $offers Rozhraní třídy pro práci s nabídkami spolupráce
     * @param StatusOfferRepositoryInterface $status_offer Rozhraní třídy pro práci se stavy nabídek spolupráce
     * @param FileRepositoryInterface $files Rozhraní třídy pro práci se soubory
     * @param FieldRepositoryInterface $fields Rozhraní třídy pro práci s obory
     */
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

    /**
     * Metoda získá data všech projektů a předá je šabloně
     * @return View Šablona pro stránku administrace projektů a nabídek spolupráce
     */
    public function index():View
    {
        $title = 'Administrace projektů a nabídek spolupráce';
        $projects = $this->projects->getAllProjects();

        return view('admin.projekty.index')
            ->with('title', $title)
            ->with('projects', $projects);
    }

    /**
     * Metoda získá příslušná data o vybraném projektu a předá je šabloně pro úpravu vybraného projektu
     * @param $id int ID vybraného projektu
     * @return mixed reprezentující šablonu pro administraci projektu | stránka 404
     */
    public function show($id): mixed
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

    /**
     * Metoda slouží pro odstranění vybraného projektu
     * @param Request $request HTTP požadavek
     * @return RedirectResponse Přesměrování na route pro admin projekty
     */
    public function destroy(Request $request): RedirectResponse
    {
        $delete_project_id = $this->testIntegerInput($request->input('delete_id_project'));
        $files = $this->files->getFilesByProjectId($delete_project_id);
        foreach ($files as $file) {
            $fileInfo = $this->files->getFileInfoById($file->id_file);
            $result = $this->files->deleteFile($file->id_file);
            if ($result == 1) {
                $fileName = basename($fileInfo[0]->unique_name . '.' . $fileInfo[0]->type);
                //unlink($target); //local delete
                Storage::disk('s3')->delete('uploads/'.$fileName); //s3 delete
            }
        }
        $result = $this->projects->deleteProjectById($delete_project_id);
        if ($result == 1) {
            return redirect()->route('admin.projekty.index')->with('delete_project', 'Odstranění projektu proběhlo úspěšně.');
        } else {
            return redirect()->route('admin.projekty.index')->with('error_delete_project', 'Odstranění projektu selhalo.');
        }
    }

    /**
     * Metoda slouží pro zpracování formulářů na stránkách pro Administraci projektů
     * @param Request $request HTTP požadavek
     * @param $id_project int ID vybraného projektu
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request, $id_project): RedirectResponse
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

    /**
     * Metoda slouží pro získání dat z formuláře a úpravu projektu
     * @param Request $request HTTP požadavek
     * @param $id_project int ID vybraného projektu
     */
    private function editProject(Request $request, $id_project):void
    {
        $request->validate([
            'edit-name-project' => 'required|string|max:255',
            'edit-abstract-project' => 'required|string|max:255',
            'edit-description-project' => 'required',
            'edit-status-project' => 'required|integer|between:1,3',
        ]);

        $edit_name = $this->testStringInput($request->input('edit-name-project'));
        $edit_abstract = $this->testStringInput($request->input('edit-abstract-project'));
        $edit_description = $this->testStringInput($request->input('edit-description-project'));
        $edit_id_status = $this->testIntegerInput($request->input('edit-status-project'));

        $this->projects->editProjectById($id_project, $edit_name, $edit_abstract, $edit_description, $edit_id_status);
    }

    /**
     * Metoda slouží pro odstranění vybraného projektu
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek odstranění souboru
     */
    private function deleteFile(Request $request): mixed
    {
        $request->validate([
            'delete_id_file' => 'required|integer'
        ]);
        $delete_id_file = $this->testIntegerInput($request->input('delete_id_file'));
        $fileInfo = $this->files->getFileInfoById($delete_id_file);
        $result = $this->files->deleteFile($delete_id_file);
        if ($result == 1) {
            $file = basename($fileInfo[0]->unique_name . '.' . $fileInfo[0]->type);
            //unlink($target);
            Storage::disk('s3')->delete('uploads/'.$file); //s3 delete
        }
        return $result;
    }

    /**
     * Metoda pro odstranění vybraného člena týmu
     * @param Request $request HTTP požadavek
     * @param $id_project int Vybraný ID projektu
     * @return mixed Výsledek funkce odstranění člena týmu
     */
    private function remove_team_member(Request $request, $id_project): mixed
    {
        $id_user = $this->testIntegerInput($request->input('remove_id_user'));
        $result = $this->users->removeTeamMember($id_project, $id_user);
        return $result;
    }

    /**
     * Metoda pro odstranění vybrané nabídky spolupráce
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek funkce pro odstranění nabídky spolupráce
     */
    private function remove_offer_cooperation(Request $request): mixed
    {
        $request->validate([
            'remove_id_offer' => 'required|integer',
        ]);
        $remove_id_offer = $this->testIntegerInput($request->input('remove_id_offer'));
        $result = $this->offers->removeOfferById($remove_id_offer);
        return $result;
    }

    /**
     * Metoda získá data z formuláře a provede úpravu nabídky spolupráce
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek funkce pro úpravu nabídky spolupráce
     */
    private function editOfferCooperation(Request $request): mixed
    {
        $request->validate([
            'edit-id-offer' => 'required|integer',
            'edit-name-offer-cooperation' => 'required|string|max:255',
            'edit-field-offer-cooperation' => 'required|integer',
            'edit-description-offer-cooperation' => 'required',
            'edit-status-offer-cooperation' => 'required|integer'
        ]);

        $edit_id_offer = $this->testIntegerInput($request->input('edit-id-offer'));
        $edit_name_offer = $this->testStringInput($request->input('edit-name-offer-cooperation'));
        $edit_description_offer = $this->testStringInput($request->input('edit-description-offer-cooperation'));
        $edit_id_status_offer = $this->testIntegerInput($request->input('edit-status-offer-cooperation'));
        $edit_id_field_offer = $this->testIntegerInput($request->input('edit-field-offer-cooperation'));

        $result = $this->offers->editOfferById($edit_id_offer, $edit_name_offer, $edit_description_offer, $edit_id_field_offer, $edit_id_status_offer);
        return $result;
    }

}
