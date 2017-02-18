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
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    </head>
    <body>
    <div id="app">
        <div class="columns">
            <form action="api/image-upload" class="column is-12 dropzone" id="my-dropzone">
                {{ csrf_field() }}
            </form>
        </div>

            <image-gallery ref="gallery"></image-gallery>

    </div>
<script type="text/javascript" src="{{asset('js/dropzone.js')}}"></script>
<script type="text/javascript" src="{{asset('js/app.js')}}"></script>

<script type="text/javascript">
Dropzone.options.myDropzone = {
  paramName: "file", // The name that will be used to transfer the file
  maxFilesize: 8, // MB
  acceptedFiles: "image/*",
  accept: function(file, done) {
      done();
  },
  success: function(file, response) {
    setTimeout(() => { this.removeFile(file); }, 1000);
    return file.previewElement.classList.add("dz-success");
  }
};

</script>
    </body>
</html>
