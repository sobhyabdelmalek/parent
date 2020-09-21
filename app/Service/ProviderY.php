<?php

namespace App\Service;

use App\Service\Provider;

class ProviderY extends Provider
{
    public  function read()
    {
        $data = file_get_contents("storage/json/providerx.json");
    }

    public  function saveImport()
    {
        dd("save Provider y");
    }

    public  function validate()
    {
        dd("validate provider y");
    }
}