<?php

namespace App\Http\Controllers;

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
use Illuminate\View\View;

/**
 * Třída reprezentující kontroller pro Moje projekty
 */
class MyProjectsController extends Controller
{
    /** @var ProjectRepositoryInterface Atribut typu repository pro práci s projekty */
    protected $projects;
    /** @var UserRepositoryInterface Atribut typu repository pro práci s uživateli */
    protected $users;
    /** @var StatusProjectRepositoryInterface Atribut typu repository pro práci se stavy projektů */
    protected $status_project;
    /** @var OfferCooperationRepositoryInterface Atribut typu repository pro práci s nabídkami spolupráce */
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
     * @param StatusOfferRepositoryInterface $status_offer Rozhraní třídy pro práci se stavy nabídek
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
     * Metoda získá data o autorských a spolupracovnických projektech uživatele a předá je šabloně
     * @return View View reprezentující šablonu pro stránku Moje projekty
     */
    public function index(): View
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

    /**
     * Metoda získá data o vybraném autorském nebo spolupracovnickém projektu a předá je šabloně
     * @param $id int ID projektu
     * @return mixed View reprezentující šablonu pro detail mého projektu | 404 stránka
     */
    public function show($id): mixed
    {
        $title = 'Úprava projektu';
        $my_project = $this->projects->getProjectById($id);

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

    /**
     * Metoda slouží pro úpravu vybraného autorského nebo spolupracovnického projektu
     * @param Request $request HTTP požadavek
     * @param $id int ID projektu
     * @return RedirectResponse Přesměrování na route pro moje projekty
     */
    public function update(Request $request, $id): RedirectResponse
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

        $this->projects->editProjectById($id, $edit_name, $edit_abstract, $edit_description, $edit_id_status);

        return redirect()->route('moje-projekty.show', $id)
            ->with('edit_project', 'Úprava projektu proběhla úspěšně.');
    }

    /**
     * Metoda slouží pro vytvoření a uložení nového projektu
     * @param Request $request HTTP požadavek
     * @return RedirectResponse Přesměrování na route pro moje projekty
     */
    public function store(Request $request): RedirectResponse
    {
        $logged_user_id = Auth::id();

        $request->validate([
            'new-name-project' => 'required|string|max:255',
            'new-abstract-project' => 'string|max:255',
            'new-description-project' => 'required',
        ]);

        $name = $this->testStringInput($request->input('new-name-project'));
        $abstract = $this->testStringInput($request->input('new-abstract-project'));
        $description = $this->testStringInput($request->input('new-description-project'));
        $create_date = date("Y-m-d H:i:s");

        $result = $this->projects->createNewProject($logged_user_id, $name, $abstract, $description, $create_date);
        if ($result == null) {
            return redirect()->route('moje-projekty.index')->with('new_project', 'Vytvoření a zveřejnění nového projektu proběhlo úspěšně.');
        } else {
            return redirect()->route('moje-projekty.index')->with('error_new_project', 'Vytvoření a zveřejnění nového projektu selhalo.');
        }
    }

    /**
     * Metoda slouží pro odstranění vybraného projektu
     * @param Request $request HTTP požadavek
     * @return RedirectResponse Přesměrování na route pro moje projekty
     */
    public function destroy(Request $request): RedirectResponse
    {
        $delete_project_id = $this->testIntegerInput($request->input('delete_id_project'));
        $result = $this->projects->deleteProjectById($delete_project_id);
        if ($result == 1) {
            return redirect()->route('moje-projekty.index')->with('delete_project', 'Odstranění projektu proběhlo úspěšně.');
        } else {
            return redirect()->route('moje-projekty.index')->with('error_delete_project', 'Odstranění projektu selhalo.');
        }
    }

    /**
     * Metoda slouží pro zpracování formulářů na stránce Moje projekty
     * @param Request $request HTTP požadavek
     * @param $id_project int ID projektu
     * @return RedirectResponse Přesměrování na konkrétní route
     */
    public function handle(Request $request, $id_project): RedirectResponse
    {
        if ($request->input('action') == 'file-upload') {
            $result = $this->file_upload($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('file-upload', 'Nahrání souboru proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-file-upload', 'Nahrání souboru selhalo.');
            }
        } else if ($request->input('action') == 'delete-file') {
            $result = $this->deleteFile($request);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('delete-file', 'Smazání souboru proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-delete-file', 'Smazání souboru selhalo.');
            }
        } else if ($request->input('action') == 'remove-team-member') {
            $result = $this->remove_team_member($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('remove_team_member', 'Odebrání člena týmu proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error_remove_team_member', 'Odebrání člena týmu selhalo.');
            }
        } else if ($request->input('action') == 'new-offer-cooperation') {
            $result = $this->new_cooperation_offer($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('new-offer-cooperation', 'Vytvoření a zveřejnění nové nabídky spolupráce proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-new-offer-cooperation', 'Vytvoření a zveřejnění nové nabídky spolupráce selhalo.');
            }
        } else if ($request->input('action') == 'remove-offer-cooperation') {
            $result = $this->remove_offer_cooperation($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('remove-offer-cooperation', 'Smazání nabídky spolupráce proběhlo úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-remove-offer-cooperation', 'Smazání nabídky spolupráce selhalo.');
            }
        } else if ($request->input('action') == 'edit-offer-cooperation') {
            $result = $this->edit_offer_cooperation($request, $id_project);
            if ($result == 1) {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('edit-offer-cooperation', 'Úprava nabídky spolupráce proběhla úspěšně.');
            } else {
                return redirect()->route('moje-projekty.show', $id_project)
                    ->with('error-edit-offer-cooperation', 'Úprava nabídky spolupráce selhala.');
            }
        }
        //default route back
        return redirect()->route('moje-projekty.show', $id_project);
    }

    /**
     * Metoda slouží pro odstranění vybraného člena týmu
     * @param Request $request HTTP požadavek
     * @param $id_project int ID projektu
     * @return mixed Výsledek odstranění člena týmu
     */
    private function remove_team_member(Request $request, $id_project): mixed
    {
        $id_user = $this->testIntegerInput($request->input('remove_id_user'));
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

        $name = $this->testStringInput($request->input('name-offer-cooperation'));
        $id_field = $this->testIntegerInput($request->input('field-offer-cooperation'));
        $description = $this->testStringInput($request->input('description-offer-cooperation'));
        $create_date = date("Y-m-d H:i:s");

        $result = $this->offers->createNewOffer($name, $description, $create_date, $id_field, $id_project);
        return $result;
    }

    /**
     * Metoda slouží pro úpravu nabídky spolupráce
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek úpravy nabídky spolupráce
     */
    private function edit_offer_cooperation(Request $request): mixed
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

    /**
     * Metoda slouží pro odstranění vybrané nabídky spolupráce
     * @param Request $request HTTP požadavek
     * @return mixed Výsledek odstranění nabídky spolupráce
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
     * Metoda slouží pro nahrání souboru k projektu
     * @param Request $request HTTP požadavek
     * @param $id_project int ID projektu
     * @return mixed Výsledek nahrání souboru
     */
    private function file_upload(Request $request, $id_project): mixed
    {
        $request->validate([
            'id_user' => 'required|integer',
            'uploadFile' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,txt|max:10000|uploaded',
        ]);
        $id_user = $this->testIntegerInput($request->input('id_user'));
        $file = $request->file('uploadFile');
        $originalName = $file->getClientOriginalName();
        $type = $file->getClientOriginalExtension();
        $uploadDate = date('Y-m-d G:i:s');
        $uploadDateTime = date("Y-m-d") . "_" . time();
        $uniqueName = $id_user . '_' . $id_project . '_' . $uploadDateTime;
        $destinationPath = storage_path() . '\app\uploads\\';
        $target = $destinationPath . basename($uniqueName . '.' . $type);
        $result = $this->files->uploadFile($id_project, $originalName, $uniqueName, $type, $uploadDate);
        move_uploaded_file($_FILES['uploadFile']['tmp_name'], $target);
        return $result;
    }

    /**
     * Metoda slouží pro odstranění vybraného souboru
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
            $destinationPath = storage_path() . '\app\uploads\\';
            $target = $destinationPath . basename($fileInfo[0]->unique_name . '.' . $fileInfo[0]->type);
            unlink($target);
        }
        return $result;
    }

}
