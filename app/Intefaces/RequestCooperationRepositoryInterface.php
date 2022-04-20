<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci se žádostmi o spolupráci
 */
interface RequestCooperationRepositoryInterface
{
    /** Metoda vrátí všechny žádosti o spolupráci */
    public function getAllRequests();
    /** Metoda vrátí všechny přijaté žádosti o spolupráci */
    public function getAllRecievedRequests($id_user);
    /** Metoda vrátí všechny odeslané žádosti o spolupráci */
    public function getAllSentRequests($id_user);
    /** Metoda vrátí konkrétní žádost o spolupráci */
    public function getRequestById($id_request);
    /** Metoda vytvoří novou žádost o spolupráci */
    public function createNewRequest($message, $create_date, $id_user, $id_offer, $id_status);
    /** Metoda zjistí, zda uživatel odeslal žádost, která čeká na schválení */
    public function userAlreadySentWaitingRequestByOfferId($id_user, $id_offer);
    /** Metoda vrátí konkrétní žádost před úpravou */
    public function getOldRequestBeforeEdit($id_request);
    /** Metoda upraví konkrétní žádost o spolupráci */
    public function editRequestById($id_request, $edit_request_message);
    /** Metoda odstraní konkrétní žádost o spolupráci */
    public function deleteRequestById($id_request);
    /** Metoda schválí konkrétní žádost o spolupráci */
    public function acceptRequestById($id_request, $id_project, $id_user);
    /** Metoda zamítne konkrétní žádost o spolupráci */
    public function rejectRequestById($id_request);
    /** Metoda vrátí žádost o spolupráci do stavu Čeká na vyřízení */
    public function setWaitingRequestById($id_request, $id_project, $id_user);
}
