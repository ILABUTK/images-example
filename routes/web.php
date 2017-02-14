<?php

use App\Events\ImageUploaded;
use App\UploadedImage;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('/images', function () {
  $images = UploadedImage::orderBy('created_at','desc')->get();
  return response()->json($images);
});


Route::post('/image-upload', function (Request $request) {
    $path = $request->file('file')->store('public/images');
    $url = Storage::url($path);
    $image = new UploadedImage;
    $image->path = $url;
    $image->save();
    event(new ImageUploaded($image));
    return response(['url' => $url]);
});
