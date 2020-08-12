@extends('layouts.app')

@section('content')
<div class="row">
  <h4 style="padding-right:10px ;" > Choose a Image:</h4>
  <input type="file" name="upload_image" id="upload_image" accept="image/*" required>
</div><br>
<hr style="background-color: black;">
  <div class="row">
    <div class="col-md-2">
      <label for="annotate">Add Annotations On Image Upload:</label>
    </div>
    <div class="col-md-10">
      <img width="600px" height="500px" id="annotate">
    </div>
  </div>
<button type="submit" id="img_upload" class="btn-lg brn btn-success">Upload Image</button>
<hr>
<h4>Annotations Made Till Now!</h4>
@foreach($image as $img)
<div class="card">
  <img class="card-img-top" id="{{$img->id}}" src="{{asset($img->image_url)}}" alt="Card image cap">
  <div class="card-body">
    <p class="card-text">Sample Image:</p>
  </div>
</div>
@endforeach

@endsection
@section('check')
<script type="text/javascript" src="{{ asset('js/annotorious.min.js') }}"></script>
<script>
  (function() {
    // Initialize the annotation part! //
    var anno = Annotorious.init({
      image: document.getElementById('annotate'), // image element or ID
      tagVocabulary: ['Needs Improvement', 'Amazing', 'Loved The Design!'],
    });

    // Upload Image & annotation's to the server
    var data = [];
    $('#img_upload').on('click', function(e) {
      e.preventDefault();
      var obj = anno.getAnnotations();
      obj.forEach(annotation => {
        annotate = {
          "@context": annotation["@context"],
          "id": annotation["id"],
          "type": annotation["type"],
          "body": annotation["body"],
          "target": {
            "selector": [annotation["target"]["selector"]]
          },
        };
        data.push(annotate);
      });
      console.log('before ajax', data);
      // Ajax request to server upload data
      $.ajax({
        url: `{{route('annotation.create')}}`,
        type: 'POST',
        headers: {
          'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        data: {
          obj: data,
          img:$('#annotate').prop('src'),
        },
        success: function(obj) {
          if(obj){
            console.log('success', obj);
            location.reload()
            alert('Uploaded the image succesfully!')
          }
          else{
            console.log('Request is invalid!');
          }
        },
        error: function(obj) {
          console.log(obj)
        },
      });
    });

    // On file selection show it in img tag!
    $("#upload_image").change(function() {
      if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#annotate').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
       
      }
    });


    // // Add event handlers using .on  
    // anno.on('createAnnotation', function(annotation) {
    //   console.log(annotation)
    //   annotate = {
    //     "@context": annotation["@context"],
    //     "id": annotation["id"],
    //     "type": annotation["type"],
    //     "body": annotation["body"],
    //     "target": {
    //       "selector": [annotation["target"]["selector"]]
    //     },
    //   };
    // });

    // Update The created annotation on a particular image
    // anno.on('updateAnnotation', function(annotation, previous) {
    //   console.log('update annotation');
    //   console.log(annotation);
    //   annotate = {
    //     "@context": annotation["@context"],
    //     "id": annotation["id"],
    //     "type": annotation["type"],
    //     "body": annotation["body"],
    //     "target": {
    //       "selector": [annotation["target"]["selector"]]
    //     },
    //   };

    //   $.ajax({
    //     url: `/annotation/update/${annotation["id"]}`,
    //     type: 'POST',
    //     headers: {
    //       'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     },
    //     data: annotate,
    //     success: function(obj) {
    //       console.log('success', obj)
    //     },
    //     error: function(obj) {
    //       console.log(obj)
    //     },
    //   });
    // });

    // // Delete The created annotation on a particular image
    // anno.on('deleteAnnotation', function(annotation) {
    //   console.log('delete annotation');
    //   console.log(annotation);
    //   annotate = {
    //     "@context": annotation["@context"],
    //     "id": annotation["id"],
    //     "type": annotation["type"],
    //     "body": annotation["body"],
    //     "target": {
    //       "selector": [annotation["target"]["selector"]]
    //     },
    //   };
    //   $.ajax({
    //     url: `/annotation/delete/${annotation["id"]}`,
    //     type: 'POST',
    //     headers: {
    //       'X_CSRF_TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //     },
    //     data: annotate,
    //     success: function(obj) {
    //       console.log('delete success', obj)
    //     },
    //     error: function(obj) {
    //       console.log(obj)
    //     },
    //   });

    // });

  })();
</script>
<script type="text/javascript">
  window.onload=function(){
    @foreach($image as $img)
    var anno = Annotorious.init({
      image: document.getElementById("{{$img->id}}"), // image element or ID
      readOnly:true,
    });
    anno.loadAnnotations("http://localhost:8000/annotation/{{$img->id}}");
    @endforeach
  }
</script>
@endsection
