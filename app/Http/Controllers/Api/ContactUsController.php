<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Interfaces\ContactUsRepositoryInterface;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    private $contactUsRepo;

    public function __construct(ContactUsRepositoryInterface $contactUsRepo)
    {
        $this->contactUsRepo    =   $contactUsRepo;
    }

    public function store(ContactUsRequest $request)
    {
        return $this->contactUsRepo->storeContactUs();
    }
}
