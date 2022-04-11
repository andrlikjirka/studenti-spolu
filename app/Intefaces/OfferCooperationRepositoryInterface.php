<?php

namespace App\Intefaces;

interface OfferCooperationRepositoryInterface
{
    public function getAllOffers($id_status);
    public function getMatchOffers($id_status);
    public function getOfferById($id_offer, $id_status);
    public function getOffersByProjectId($id_project);
    public function createNewOffer($name, $description, $create_date, $id_field, $id_project, $id_status);
    public function editOfferById($id_offer, $edit_name_offer, $edit_description_offer, $edit_id_field_offer, $edit_id_status_offer);
    public function removeOfferById($id_offer);
    public function getActiveOffersByProjectId($id_project);
}
