<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * List all users with filter
     * @return Illuminate\Http\Resources\Json\JsonResource;
     */
    public function index(Request $request)
    {
        $users = User::filter($request->query())->paginate();

        return UserResource::collection($users);
    }
}
