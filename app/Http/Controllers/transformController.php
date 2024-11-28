<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class transformController extends Controller
{
    public function index(Request $request)  {

    return view('images.transform_list',[
        'user'=> $request->user(),
    ]);
    }
    public function create(Request $request)  {

    return view('images.transform',[
        'user'=> $request->user(),
    ]);
    }
}
