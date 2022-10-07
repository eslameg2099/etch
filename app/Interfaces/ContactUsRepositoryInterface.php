<?php


namespace App\Interfaces;

use Illuminate\Http\Request;

interface ContactUsRepositoryInterface
{
    public function getAllContactUs();

    public function storeContactUs();

    public function deleteContactUs();
}
