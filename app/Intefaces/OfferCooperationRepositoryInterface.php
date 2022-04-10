<?php

namespace App\Intefaces;

interface OfferCooperationRepositoryInterface
{
    public function getAllOffers($id_status);
    public function getMatchOffers($id_status);
    public function getOfferById($id_offer, $id_status);
    public function createNewRequest($message, $create_date, $id_user, $id_offer, $id_status);
    public function getOffersByProjectId($id_project);
}
