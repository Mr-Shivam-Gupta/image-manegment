<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\image;

class imagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('images.index',[
            'user' => $request->user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //  dd($request);
        return view('images.create',[
            'user' => $request->user(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request);
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
        $metaData['image_size'] = $imageFile->getSize();
        $metaData['image_extension'] = $imageFile->getClientOriginalExtension();
        // $imageDimensions = getimagesize($imageFile);
        // if ($imageDimensions) {
        //     $metaData['image_width'] = $imageDimensions[0];  // Width
        //     $metaData['image_height'] = $imageDimensions[1]; // Height
        // }
        $validatedData['mata_data'] = $metaData;
        image::create($validatedData);

 return redirect()->route('images.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
