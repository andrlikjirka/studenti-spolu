<?php

namespace App\Intefaces;

/**
 * Rozhraní obalové třídy pro práci s nabídkami spolupráce
 */
interface OfferCooperationRepositoryInterface
{
    /** Metoda vrátí všechny nabídky spolupráce */
    public function getAllOffers($id_status);
    /** Metoda vrátí nabídky spolupráce vztažené k oborům znalostí a dovedností uživatele */
    public function getMatchOffers($id_status);
    /** Metoda vrátí konkrétní nabídku spolupráce */
    public function getOfferById($id_offer, $id_status);
    /** Metoda vrátí nabídky spolupráce vztažené ke konkrétnímu projektu */
    public function getOffersByProjectId($id_project);
    /** Metoda vytvoří novou nabídku spolupráce */
    public function createNewOffer($name, $description, $create_date, $id_field, $id_project, $id_status);
    /** Metoda upraví konkrétní nabídku spolupráce */
    public function editOfferById($id_offer, $edit_name_offer, $edit_description_offer, $edit_id_field_offer, $edit_id_status_offer);
    /** Metoda odstraní vybranou nabídku spolupráce */
    public function removeOfferById($id_offer);
    /** Metoda vrátí aktivní nabídky spolupráce vztažené ke konkrétnímu projektu */
    public function getActiveOffersByProjectId($id_project);
}
