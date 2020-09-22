<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ProviderX;
use App\Service\ProviderY;

class ProviderController extends Controller
{
    public function test(ProviderY $pro)
    {
        $pro->saveImport();
        dd("done");
    }
}
