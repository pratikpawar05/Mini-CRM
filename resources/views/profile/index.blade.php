@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-header bg-success">Profile Update</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label>Profile Pic:</label>
            </div>
            <div id="uploaded_image" align="center" style="margin: 10px;">
                <img src="{{asset($user['profile_pic_url'])}}" class="rounded-0" width="150px">
            </div>
            <div class="col-md-4">
                <p><label>Update Image</label></p>
                <input type="file" name="upload_image" id="upload_image" accept="image/*">
            </div>
        </div><br>
        <form id="updateUser" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-4">
                    <label>Name:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" value="{{$user['name']}}" name="name" width="100%" />
                </div>
            </div><br><br>
            <div class="row">
                <div class="col-md-4">
                    <label>Email:</label>
                </div>
                <div class="col-md-8">
                    <input type="email" value="{{$user['email']}}" name="email" width="100%">
                </div>
            </div><br><br>
            <div class="row">
                <div class="col-md-4">
                    <label>Password:</label>
                </div>
                <div class="col-md-8">
                    <input type="password" id="userPassword" placeholder="Want to change password?" name="password" width="100%">
                    <input type="checkbox" id="password_toggle">Show Password
                </div>
            </div><br><br>
            <div class="row">
                <div class="col-md-4">
                    <label>Notification Status:</label>
                </div>
                <div class="col-md-8" style="display: inline-block;">
                    @if($user['notification_status']=='0')
                    <input type="checkbox" id="notification" data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
                    @else
                    <input checked type="checkbox" id="notification" data-toggle="toggle" data-onstyle="success" data-offstyle="danger">
                    @endif
                    <input type="hidden" id="notification_status" name="notification_status" value="{{$user['notification_status']}}">
                </div>
            </div><br><br>
            <div class="row">
                <div>
                    <div class="col-md-4">
                        <button class="btn btn-success text-dark" id="updateUserProfile">Update</button>
                    </div>
                </div>
            </div><br><br>
        </form>
    </div>
</div>
<!-- Update Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crop and Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateEmployee" enctype="multipart/form-data" class="form">
                    <div class="form-group">
                        <div id="image-preview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeImageUpdate">Close</button>
                        <button type="submit" class="btn btn-primary crop_image" id="updateEmployeeData" data-dismiss="modal">Crop & Upload Image</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Modal Ends-->
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/croppie.css') }}" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection
@section('scripts')

<script type="text/javascript">
    (function($) {
        $(document).ready(function() {
            $image_crop = $('#image-preview').croppie({
                enableExif: true,
                enableOrientation: true,
                viewport: {
                    width: 150,
                    height: 150,
                    type: 'circle'
                },
                boundary: {
                    width: 300,
                    height: 300
                },
                showZoomer: true,
            });

            $('#upload_image').change(function() {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function() {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                window.$('#myModal').modal('show');
            });

            $('.crop_image').click(function(event) {
                event.preventDefault();
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport',
                    circle:true,
                }).then(function(response) {
                    var _token = $('input[name=_token]').val();
                    jQuery.ajax({
                        url: `{{route('profile.store',Auth::id())}}`,
                        type: 'POST',
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        data: {
                            image:response,
                            _token: _token,
                        },
                        dataType:'json',
                        success: function(data) {
                        console.log(data['success'])
                           if(data['success']){
                            var crop_image = '<img src="' + data['success'] + '" class="rounded-0"/>';
                            $('#uploaded_image').html(crop_image);
                            $('#upload_image').val('');
                           }
                           else{
                               alert(data['error']);
                           }

                        },
                        error:function(err){
                            console.log(JSON.stringify(err));
                        }
                    });
                });
            });

        });

        //Clear the file
        $('#closeImageUpdate').on('click',function(e){
            $('#upload_image').val('');
        });
    })(jQuery);
    // Password hide show
    $('#password_toggle').on('change', function(e) {
        password = $('#userPassword');
        if (password.prop('type') == 'password') {
            password.prop('type', 'text')
        } else {
            password.prop('type', 'password')
        }
    });
    //Notification Status on/off
    $(document).on('click', '.toggle', function(e) {
        jQuery.noConflict();
        if ($('#notification_status').val() == '1') {
            $('#notification').bootstrapToggle('off')
            $('#notification_status').val('0')
        } else {
            Notification.requestPermission().then((permission) => {
                if (permission == 'granted') {
                    $('#notification').bootstrapToggle('on');
                    $('#notification_status').val('1')
                } else if (permission == 'denied') {
                    $('#notification').bootstrapToggle('off');
                    $('#notification_status').val('0')
                    alert('You have denied the notification permission,plz allow or choose to ask first!')
                } else {
                    console.log('default');
                }
            });
        }
    });

    //Submit(update) the user profile
    $('#updateUserProfile').on('click',function(e){
        e.preventDefault();
        var formData = new FormData($('#updateUser')[0]);
        jQuery.ajax({
            url: `{{route('profile.update',Auth::id())}}`,
            type: 'POST',
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:formData,
            success: function(msg) {
                alert('User Profile Updated Succesfully!')
                location.reload();
            },
            error: function(error) {
                console.log(JSON.stringify(error));
            }
        });
    });
</script>
@endsection