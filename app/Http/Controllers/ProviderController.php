<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\ProviderX;

class ProviderController extends Controller
{
    public function test(ProviderX $pro)
    {
        //$pro->saveImport();
        $pro->read();
    }
}
