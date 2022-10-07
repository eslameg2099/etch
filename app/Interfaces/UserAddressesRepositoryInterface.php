<?php


namespace App\Interfaces;


use Illuminate\Http\Request;

interface UserAddressesRepositoryInterface
{
    public function getAddresses();

    public function getMyAddress();

    public function getAddress($id);

    public function storeOrUpdateAddress(Request $request, $id = null);

    public function deleteAddress($id);

}
