<?php


namespace App\Repositories;


use App\Http\Resources\Users\AddressResource;
use App\Interfaces\ContactUsRepositoryInterface;
use App\Interfaces\UserAddressesRepositoryInterface;
use App\Models\ContactUs;
use App\Models\Users\Address;
use App\Traits\RepositoryResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsRepositories implements ContactUsRepositoryInterface
{
    use RepositoryResponseTrait;

    public function getAllContactUs()
    {
        // TODO: Implement getAllContactUs() method.
    }

    public function storeContactUs()
    {
        ContactUs::query()->create([
            'name'      =>  \request('name'),
            'email'     =>  \request('email'),
            'mobile'    =>  \request('mobile'),
            'message'   =>  \request('message'),
        ]);

        return $this->success(['message' => trans('global.operation_succeeded')]);
    }

    public function deleteContactUs()
    {
        // TODO: Implement deleteContactUs() method.
    }
}
