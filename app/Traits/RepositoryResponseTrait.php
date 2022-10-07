<?php


namespace App\Traits;


use App\Enums\StatusCodesEnums;

trait RepositoryResponseTrait
{
    public function error($data) {
        return response()->json($data , StatusCodesEnums::NotFoundStatus);
    }

    public function serverError($data) {
        return response()->json($data , StatusCodesEnums::ServerErrorStatus);
    }

    public function validationError($data) {
        return response()->json($data , StatusCodesEnums::ValidationStatus);
    }

    public function success($data) {
        return response()->json($data , StatusCodesEnums::SuccessStatus);
    }
}
