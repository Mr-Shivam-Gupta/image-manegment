<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\image;

class imgContoller extends Controller
{
    public function index(Request $request)
    {
        $images = image::where('user_id',$request->user()->id)->get();
        return view('images.index', [
            'user' => $request->user(),
            'images' => $images
        ]);
    }
    public function create(Request $request)
    {

        return view('images.create', [
            'user' => $request->user(),
        ]);
    }
    public function store(Request $request)
    {

        // DB::enableQueryLog(); // Start logging queries

        $validatedData = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $validatedData['description'] = $request->description;
        $validatedData['ip_address'] = $request->ip();
        $validatedData['user_id'] = $request->user()->id;
        $validatedData['browser'] = $request->header('User-Agent');


        if ($request->hasFile('image')) {
            $imageFile = $request->image;
            // Get metadata before moving the file
            $metaData['image_name'] = $imageFile->getClientOriginalName();
            $metaData['image_extension'] = $imageFile->getClientOriginalExtension();
            $metaData['image_size'] = $imageFile->getSize();
            $imageDimensions = getimagesize($imageFile);
            if ($imageDimensions) {
                $metaData['image_width'] = $imageDimensions[0];  // Width
                $metaData['image_height'] = $imageDimensions[1]; // Height
            }
            $validatedData['mata_data'] = json_encode($metaData);

            $imageName = date('Y_m_d-His') . '.' . $metaData['image_extension'];
            $imageFile->move(public_path('images'), $imageName);

            $validatedData['image'] = $imageName;
        }

        $imageUploaded =   image::create($validatedData);
        // echo '<pre>';
        // print_r(DB::getQueryLog());
        // echo '</pre>';
        // die;
        if ($imageUploaded) {
            return redirect()->route('images.index')->with('success', 'image uploaded successfull!');
        } else {
            return redirect()->route('images.index')->with('error', 'image uploadation failed!');
        }
    }
    public function edit(Request $request, string $id){

        $image = image::findOrFail($id);
        if($image->user_id == $request->user()->id){

            return view('images.edit', [
                'user' => $request->user(),
                'image'=> $image,
            ]);
        }else{
            return back()->with('error','access not allowed!');
        }
    }

    public function update(Request $request, string $id){
        $image = image::findOrFail($id);

        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg|max:10000',
        ]);
        $validatedData['description'] = $request->description;
        $validatedData['ip_address'] = $request->ip();
        $validatedData['user_id'] = $request->user()->id;
        $validatedData['browser'] = $request->header('User-Agent');

        if ($request->hasFile('image')) {
            $imageFile = $request->image;
            // Get metadata before moving the file
            $metaData['image_name'] = $imageFile->getClientOriginalName();
            $metaData['image_extension'] = $imageFile->getClientOriginalExtension();
            $metaData['image_size'] = $imageFile->getSize();
            $imageDimensions = getimagesize($imageFile);
            if ($imageDimensions) {
                $metaData['image_width'] = $imageDimensions[0];  // Width
                $metaData['image_height'] = $imageDimensions[1]; // Height
            }
            $validatedData['mata_data'] = json_encode($metaData);

            $imageName = date('Y_m_d-His') . '.' . $metaData['image_extension'];
            $imageFile->move(public_path('images'), $imageName);

            $validatedData['image'] = $imageName;
        }
        $imageUpdated = $image->update($validatedData);

        if ($imageUpdated) {
            return redirect()->route('images.index')->with('success', 'image updates successfull!');
        } else {
            return redirect()->route('images.index')->with('error', 'image updation failed!');
        }
    }

    public function destroy(string $id)
    {
        $image = image::findOrFail($id);
        $image->delete();
        return redirect()->back()->with('success', 'image deleted successfully!');
    }
}
