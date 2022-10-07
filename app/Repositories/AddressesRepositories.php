<?php


namespace App\Repositories;


use App\Http\Resources\Users\AddressResource;
use App\Interfaces\UserAddressesRepositoryInterface;
use App\Models\Users\Address;
use App\Traits\RepositoryResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressesRepositories implements UserAddressesRepositoryInterface
{
    use RepositoryResponseTrait;
    public function getAddresses()
    {
        // TODO: Implement getAddresses() method.
    }

    public function getMyAddress()
    {
        return AddressResource::collection(\request()->user()->addresses);
    }

    public function getAddress($id)
    {
        // TODO: Implement getAddress() method.
    }

    public function storeOrUpdateAddress(Request $request, $id = null)
    {
        DB::beginTransaction();
        try{
            $address    =   $id ? $request->user()->addresses()->find($id) : new Address();

            $address->user_id   =   $request->user()->id;
            $address->city_id   =   $request->city_id;
            $address->name = $request->name;
            $address->address = $request->address;
            $address->lat = $request->lat;
            $address->lng = $request->long;
            $address->is_default = $request->is_default;

            $address->save();
            DB::commit();

            return $this->success([
                'message'   =>  trans('global.operation_succeeded'),
                'address'   =>  new AddressResource($address),
            ]);
        } catch (\Exception  $e) {
            DB::rollBack();
            return $this->serverError(['message'=>$e->getMessage()]);
        }
    }

    public function deleteAddress($id)
    {
        $address    =   \request()->user()->addresses()->find($id);
        if(!$address) { return $this->error(['errors'=>trans('errors.cannot_find_addresses')]);}
        $address->delete();
        return $this->success(['message'=>trans('global.deleted_success')]);
    }

}
