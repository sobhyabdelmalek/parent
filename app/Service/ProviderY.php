<?php

namespace App\Service;

use App\Service\Provider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProviderY extends Provider
{
    protected $path = "providery.json";

    protected $name = "providerY";

    public  function validate($user)
    {
        return Validator::make($user, [
            "balance" => 'required',
            "currency" => "required",
            "email" => "required",
            "status" => "required|in:100,200,300",
            "created_at" => "required",
            "id" => "required"
        ]);
    }

    public function transfer($user)
    {
        return [
            'id' => $user["id"],
            'email' => $user["email"],
            'amount' => $user["balance"],
            'currency' => $user["currency"],
            'status' => $this->getStatus($user["status"]),
            'registeration' => Carbon::createFromFormat("d/m/Y", $user['created_at'])->format('Y-m-d'),
            'provider' => $this->name   
        ];
    }
}