<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = new User;

        if($request->has('sortBy'))
        {
            if($request->get('sortDesc') === true)
            {
                $user = $user->orderBy($request->get('sortBy'), 'desc');
            }else{
                $user = $user->orderBy($request->get('sortBy'), 'asc');
            }
        }else{
            $user = $user->orderBy('id', 'desc');
        }

        $searchValue = $request->input('search');

        if($searchValue)
        {
            $user->where(function($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%');
            });
        }

        $itemsPerPage = 10;

        if($request->has('itemsPerPage'))
        {
            $itemsPerPage = $request->get('itemsPerPage');
        }

        return $user->paginate($itemsPerPage);
    }
}
