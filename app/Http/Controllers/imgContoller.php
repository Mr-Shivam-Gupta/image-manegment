<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class imgContoller extends Controller
{
    public function index(Request $request)
    {
        return view('images.index',[
            'user' => $request->user(),
        ]);
    }
    public function create(Request $request)
    {

        return view('images.create',[
            'user' => $request->user(),
        ]);
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10000',
            'description' =>'string',
        ]);
        $validatedData['ip_address'] = $request->ip();
        $validatedData['browser'] = $request->header('User-Agent');;

        if($request->hasFile('image')){
            $imageName =date('Y_m_d-His').'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'),$imageName);
        }

        $imageFile = $request->image;
        $metaData['image_name'] = $imageFile->getClientOriginalName();
        $metaData['image_extension'] = $imageFile->getClientOriginalExtension();

        $metaData['image_size'] =  $request->file('image')->getSize();
        // $metaData['image_size'] = $imageFile->getSize();
        // $imageDimensions = getimagesize($imageFile);
        // if ($imageDimensions) {
        //     $metaData['image_width'] = $imageDimensions[0];  // Width
        //     $metaData['image_height'] = $imageDimensions[1]; // Height
        // }
        $validatedData['mata_data'] = $metaData;
        dd($validatedData);
    }

}
