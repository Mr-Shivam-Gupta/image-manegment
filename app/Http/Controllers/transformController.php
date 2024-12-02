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

    return view('images.transform',[
        'user'=> $request->user(),
    ]);
    }
    public function create(Request $request)  {
    return view('images.transform',[
        'user'=> $request->user(),
    ]);
    }

    public function transform(Request $request, ){

    if ($request->hasFile('image') && $image = $request->file('image')) {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('upload'), $imageName);

        // $imgManager = new ImageManager(new Driver());
        $imgManager =ImageManager::gd();
        $thumbImage = $imgManager->read(public_path('upload/' . $imageName));

        if ($request->has('rotate') && !$request->extension) {
            $rotateDegree = (int)$request->input('rotate');
            $thumbImage->rotate($rotateDegree);
            // ->fill('#ffffff00', 300);
        }

        if ($request->has('flip_horizontal') && $request->flip_horizontal == 'true' && !$request->extension) {
            $thumbImage->flop('h');
        }
        if ($request->has('flip_vertical') && $request->flip_vertical == 'true' && !$request->extension) {
            $thumbImage->flip('v');
        }

        if($request->resize_width && !$request->water_mark && $request->resize && !$request->extension){
            $thumbImage->resizeDown(width: $request->resize_width);
        }
        if( $request->resize_height && !$request->water_mark && $request->resize && !$request->extension){
            $thumbImage->resizeDown(height: $request->resize_height);
        }

        if($request->water_mark != '' && $request->water_mark != null && !$request->extension){
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
            $font->filename('./font/BuzluBuz.ttf');
            $font->size(40);
            $font->color('fff');
            $font->stroke('e46ba0', 2);
            $font->align('center');
            $font->valign('middle');
            $font->lineHeight(1.6);
            $font->angle(0);
            $font->wrap(250);
            });
        }

        if (
            ($request->has('crop_x') || $request->has('crop_y') || $request->has('crop_width') || $request->has('crop_height'))  && (!$request->water_mark) && !$request->resize && !$request->extension ) {
            $cropX = (int)$request->input('crop_x');
            $cropY = (int)$request->input('crop_y');
            $cropWidth = (int)$request->input('crop_width');
            $cropHeight = (int)$request->input('crop_height');
            $thumbImage->crop($cropWidth, $cropHeight, $cropX, $cropY);
        }
        if ($request->filter) {
            $filter = $request->input('filter');
            switch ($filter) {
                case 'grayscale':
                    $thumbImage->greyscale();
                    break;
                case 'invert':
                    $thumbImage->invert();
                    break;
                case 'gamma':
                    $thumbImage->gamma(1.7);
                    break;
                case 'reduce-colors':
                    $thumbImage->reduceColors(10);
                    break;
                case 'brightness':
                    $thumbImage->brightness(35);
                    break;
                case 'contrast-increasing':
                    $thumbImage->contrast(10);
                    break;
                case 'contrast-decreasing':
                    $thumbImage->contrast(-10);
                    break;
                case 'blur':
                    $thumbImage->blur(15);
                    break;
                case 'pixelate':
                    $thumbImage->pixelate(7);
                    break;
                case 'sharpening':
                    $thumbImage->sharpen(10);
                    break;
                default:
                    break;
            }
        }

        if($request->extension){
            $newImageName = time() . '.' . $request->extension;
            $thumbImage->save(public_path('thumbnail/' . $newImageName),100,$request->extension);
        }else{
            $thumbImage->save(public_path('thumbnail/' . $imageName));
        }
        return back();

    }
}


}
