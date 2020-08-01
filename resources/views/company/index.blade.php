@extends('layouts/app')
@section('add')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('company.create') }}" class="btn btn-success">Add Company</a>
</div>
@endsection
@section('content')
@if(request()->session()->has('registered'))
<div class="form-group">
    <div class="alert alert-danger">
        <ul class="list-group" id="errors">
            {{ session('registered') }}
        </ul>
    </div>
</div>
@endif
<div class="form-group">
    <div class="alert alert-danger">
        <ul class="list-group" id="errors">
        </ul>
    </div>
</div>
<div class="card card-default">
    <div class="card-header bg-info">
        Company Record
    </div>
    <div class="card-body">
        <table class="table" id="companyData" width="100%">
            <thead>
                <th>Company Name:</th>
                <th>Email:</th>
                <th>Website URL:</th>
                <th>Logo:</th>
                <th>Action:</th>
            </thead>
            <tbody>
            </tbody>
        </table>
        <!-- Update Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form enctype="multipart/form-data" class="form" id="updateCompany">
                            <div class="form-group" readonly>
                                <label for="name" class="col-form-label">Name:</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                            <div class="form-group">
                                <label for="website_url" class="col-form-label">Website_url:</label>
                                <input type="text" class="form-control" name="website_url" id="website_url">
                            </div>
                            <div class="form-group">
                                <label for="logo" class="col-form-label">logo:</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="updateCompanyData" data-dismiss="modal">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Update Modal Ends-->
    </div>
</div>
@endsection
@section('scripts')

<script>
    // Server side rendering using datatables!
    $(document).ready(function() {
        $.noConflict();
        $('.alert-danger').hide();
        $('#companyData').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('company.index') }}",
            "columns": [{
                    data: "name",
                    name: "name"
                },
                {
                    data: "email",
                    name: "email"
                },
                {
                    data: "website_url",
                    name: "website_url"
                },
                {
                    data: "comp_logo",
                    name: "logo"
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false
                }
            ]
        });
    });

    // Set the modal with employee Data
    var self_id;
    $(document).on('click', 'button[name="edit"]', function(e) {
        self_id = $(this).attr('id');
        tr = $(this).parent().parent();
        name = tr.find('td:eq(0)').text();
        email = tr.find('td:eq(1)').text();
        website_url = tr.find('td:eq(2)').text();
        logo = tr.find('td:eq(3)').attr('src');
        $('#myModal #name').val(name);
        $('#myModal #email').val(email);
        $('#myModal #website_url').val(website_url);
        // $('#myModal #logo').val(logo);
    });

    //Update the company data
    $('#updateCompanyData').on('click', function(e) {
        e.preventDefault();
        var formData = new FormData($('#updateCompany')[0]);
        $.ajax({
            url: `/company/update/${self_id}`,
            type: 'POST',
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function(obj) {
                location.reload();
                alert(obj);
            },
            error: function(error) {
                $('.alert-danger .list-group').empty()
                $('.alert-danger').show();
                temp_err=error['responseJSON']['errors']
                for(const err in temp_err){
                    $('#errors').append('<li class="list-group-item">'+temp_err[err][0]+'</li>')
                    // console.log(temp_err[err][0])
                }
            }
        });
        $('#logo').val('');
    });


    //Delete Company Data from the database
    $(document).on('click', 'button[name="delete"]', function(e) {
        id = $(this).attr('id');
        $.ajax({
            url: `/company/delete/${id}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(e) {
                alert('Company Deleted Succesfully!')
                location.reload();
            },
            error: function(error) {
                console.log(JSON.stringify(error));
            }
        });
    });
</script>

@endsection