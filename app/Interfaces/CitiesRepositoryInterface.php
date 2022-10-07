<?php


namespace App\Interfaces;

use Illuminate\Http\Request;

interface CitiesRepositoryInterface
{
    public function getCities();

    public function getCity($id);

    public function storeOrUpdateCity(Request $request, $id = null);

    public function deleteCity($id);
}
