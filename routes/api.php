<?php

use Illuminate\Http\Request;
use App\UploadedImage;
use App\Events\ImageUploaded;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/images', function (Request $request) {
  if($request->has('lastID')){
    $images = UploadedImage::orderBy('id','desc')->where('id', '<',  $request->get('lastID'))->take(15)->get();
    return response()->json($images);
  } else {
    $images = UploadedImage::orderBy('id','desc')->take(15)->get();
    return response()->json($images);
  }
});

Route::post('/image-upload', function (Request $request) {
  $uploadFile = $request->file('file');
  $fullName = $uploadFile->getClientOriginalName();

  $path = $uploadFile->store('public/images');
  // $url = Storage::url($path);

  $filename = pathinfo($path)['filename'].'_prev.jpeg';

  // open an image file
  $img = Image::make($uploadFile->getRealPath());

  // resize only the width of the image
  $img->resize(320, null, function ($constraint) {
        $constraint->aspectRatio();
  })->encode('jpg');

  // finally we save the image as a new file
  $preview_path = 'public/images/'.$filename;
  Storage::put($preview_path, $img);

  // $preview_url = Storage::url('public/images/'.$filename);

  $image = new UploadedImage;
  $image->path = $path;
  $image->name = $fullName;
  $image->preview_path = $preview_path;
  $image->save();

  event(new ImageUploaded($image));
  return response('OK');
});

Route::delete('/images/{image}', function (UploadedImage $image) {
  Storage::delete([$image->path, $image->preview_path]);
  $image->delete();
  return response('OK');
});
