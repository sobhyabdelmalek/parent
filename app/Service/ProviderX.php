<?php

namespace App\Service;

use App\Service\Provider;

class ProviderX extends Provider
{
    protected $path = "providerx.json";

    public  function read()
    {
        return parent::read();
    }

    public  function saveImport()
    {
        $users = $this->read();

        foreach ($users as $key => $user) {
            # code...
        }
    }

    public  function validate()
    {
        //validate each user 
    }
}