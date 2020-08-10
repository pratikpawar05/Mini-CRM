@extends('layouts.app')

@section('content')
<h4>Choose a Image:</h4>
<div class="row">
        <input type="file" name="upload_image" id="upload_image" accept="image/*">
</div><br>
<div class="row">
    <img width="500px" height="500px" id="annotate">
</div>
@endsection
@section('check')
<script type="text/javascript" src="{{ asset('js/annotorious.min.js') }}"></script>
<script >
(function() {
      var anno = Annotorious.init({
        image: document.getElementById('annotate'), // image element or ID
        tagVocabulary:['Fun','Checking','Now'],
      });      
      // Add event handlers using .on  
      anno.on('createAnnotation', function(annotation) {
          console.log(annotation)
        });
        anno.on('updateAnnotation', function(annotation, previous) {
          //
          console.log('update annotation');
          console.log(annotation);

        });
        $("#upload_image").change(function () {
          if (this.files && this.files[0]) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  $('#annotate').attr('src', e.target.result);
              }
              reader.readAsDataURL(this.files[0]);
              anno.loadAnnotations("{{ asset('js/annotations.w3c.json')}}");
          }
       });
    })();
</script>
@endsection