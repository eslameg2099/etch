<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\StoreAddressRequest;
use App\Http\Requests\Users\UpdateAddressRequest;
use App\Interfaces\UserAddressesRepositoryInterface;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    private $addressRepo;
    public function __construct(UserAddressesRepositoryInterface $addressRepo)
    {
        $this->addressRepo = $addressRepo;
    }

    public function index() {
        return $this->addressRepo->getMyAddress();
    }

    public function store(StoreAddressRequest $request) {
        return $this->addressRepo->storeOrUpdateAddress($request);
    }

    public function update(UpdateAddressRequest $request) {
        return $this->addressRepo->storeOrUpdateAddress($request, $request->address_id);
    }

    public function destroy($id) {
        return $this->addressRepo->deleteAddress($id);
    }
}
