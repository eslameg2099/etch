<?php

namespace App\Http\Controllers\Api\MasterData;

use App\Http\Controllers\Controller;
use App\Interfaces\CitiesRepositoryInterface;
use App\Models\MasterData\SmsLog;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    private $cityRepo;

    public function __construct(CitiesRepositoryInterface $cityRepo)
    {
        $this->cityRepo = $cityRepo;
    }

    public function index() {
        return $this->cityRepo->getCities();
    }
}
