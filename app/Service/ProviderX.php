<?php

namespace App\Service;

use App\Service\Provider;
use Illuminate\Support\Facades\Validator;

class ProviderX extends Provider
{
   
    protected $path = "providerx.json";

    protected $name = "providerX";

    public  function validate($user)
    {
        return Validator::make($user, [
            "parentAmount" => 'required',
            "Currency" => "required",
            "parentEmail" => "required",
            "statusCode" => "required|in:1,2,3",
            "registerationDate" => "required",
            "parentIdentification" => "required"
        ]);
    }

    public function transfer($user)
    {
        return [
            'id' => $user["parentIdentification"],
            'email' => $user["parentEmail"],
            'amount' => $user["parentAmount"],
            'currency' => $user["Currency"],
            'status' => $this->getStatus($user["statusCode"]),
            'registeration' => $user["registerationDate"],
            'provider' => $this->name   
        ];
    }
}