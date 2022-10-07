<?php


namespace App\Interfaces;


use Illuminate\Http\Request;

interface UsersRepositoryInterface
{
    public function getUsers();

    public function getUser($id);

    public function getUserByMobile();

    public function storeOrUpdateUser(Request $request, $id = null);

    public function deleteUser($id);

    public function changePassword();

    public function resetMyPassword();

    public function StoreDelegateLastLocation(Request $request);
}
