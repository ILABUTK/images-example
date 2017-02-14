<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Images upload sample</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="{{asset('css/dropzone.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('css/aside.css')}}">
    </head>
    <body>
        <form action="/image-upload" class="dropzone" id="my-dropzone">
            {{ csrf_field() }}
        </form>
        <div class="columns files is-multiline">
@foreach ($images as $image)
        <div class="column is-6-tablet is-3-desktop">
          <a class="file">
            <div class="image">
                  <img src="{{ $image->path }}" alt="Image">
            </div>
            <div class="name">swimmin.jpeg</div>
            <div class="timestamp">2 hours ago</div>
          </a>
        </div>  
@endforeach                 
        </div>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>        
<script type="text/javascript" src="{{asset('js/dropzone.js')}}"></script>
<script type="text/javascript">
Dropzone.options.myDropzone = {
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 8, // MB
  acceptedFiles: "image/*",
    accept: function(file, done) {
      done();
  }
};   
</script>
    </body>
</html>