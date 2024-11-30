<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\image as imageModel;
use Intervention\Image\Facades\Image;  // Correct import for Intervention Image

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Intervention\Image\Typography\FontFactory;

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



    if ($request->hasFile('image') && $image = $request->file('image')) {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload'), $imageName);

        // $imgManager = new ImageManager(new Driver());
        $imgManager =ImageManager::gd();
        $thumbImage = $imgManager->read(public_path('upload/' . $imageName));

        if ($request->has('rotate')) {
            $rotateDegree = (int)$request->input('rotate');
            $thumbImage->rotate($rotateDegree);
            // ->fill('#ffffff00', 300);
        }
        if ($request->has('flip_horizontal') && $request->flip_horizontal == 'true') {
            $thumbImage->flop('h');
        }
        if ($request->has('flip_vertical') && $request->flip_vertical == 'true') {
            $thumbImage->flip('v');
        }

        if($request->has('resize_width') && !$request->has('water_mark') ){
            $thumbImage->resizeDown(width: $request->resize_width);
        }
        if( $request->has('resize_height') && !$request->has('water_mark')){
            $thumbImage->resizeDown(height: $request->resize_height);
        }
        // dd($request);

        if($request->water_mark != '' && $request->water_mark != null){
            if ((int)$request->crop_x == 0) {
               $crop_x = 100;
            }else{
                $crop_x =(int)$request->crop_x;
            }
            if ((int)$request->crop_y == 0) {
               $crop_y = 100;
            }else{
                $crop_y =(int)$request->crop_y;
            }
            $thumbImage->text($request->water_mark, $crop_x, $crop_y,function (FontFactory $font){
            $font->size(200);
            $font->color('000');
            $font->stroke('fff', 2);
            $font->align('center');
            $font->valign('middle');
            });
        }

        if (
            ($request->has('crop_x') || $request->has('crop_y') || $request->has('crop_width') || $request->has('crop_height'))  && (!$request->water_mark)) {
        // if (
        //     ($request->has('crop_x') || $request->has('crop_y') || $request->has('crop_width') || $request->has('crop_height'))
        //     && (!$request->has('resize_width') || !$request->has('resize_height'))
        //      && (!$request->has('water_mark'))) {

            // dd($request);
            $cropX = (int)$request->input('crop_x');
            $cropY = (int)$request->input('crop_y');
            $cropWidth = (int)$request->input('crop_width');
            $cropHeight = (int)$request->input('crop_height');
            $thumbImage->crop($cropWidth, $cropHeight, $cropX, $cropY);
        }

        // Save the transformed image
        $thumbImage->save(public_path('thumbnail/' . $imageName));

        return back();

    }
}


}
