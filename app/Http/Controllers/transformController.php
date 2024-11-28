<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
    
    public function transform(Request $request, string $id = null){
      
     
        $image = $request->file('image');
        $imageName = time().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload'),$imageName);

        $imgManager = new ImageManager(new Driver());
        $thumbImage = $imgManager->read('upload/'.$imageName);
        $thumbImage->resize(300,300);

        $thumbImage->save(public_path('thambnail/'.$imageName));
        return back();

    }
}
