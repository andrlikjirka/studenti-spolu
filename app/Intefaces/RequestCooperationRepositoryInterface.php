<?php

namespace App\Intefaces;

interface RequestCooperationRepositoryInterface
{
    public function getAllRecievedRequests($id_user);
    public function getAllSentRequests($id_user);
    public function createNewRequest($message, $create_date, $id_user, $id_offer, $id_status);
    public function userAlreadySentWaitingRequestByOfferId($id_user, $id_offer);
    public function getOldRequestBeforeEdit($id_request);
    public function editRequestById($id_request, $edit_request_message);
    public function deleteRequestById($id_request);
    public function acceptRequestById($id_request, $id_project, $id_user);
    public function rejectRequestById($id_request);
    public function setWaitingRequestById($id_request, $id_project, $id_user);
}
