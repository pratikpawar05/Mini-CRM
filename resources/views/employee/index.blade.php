@extends('layouts/app')
@section('add')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('employee.create') }}" class="btn btn-success btn-md text-dark">Add Employee</a>
</div>
@endsection
@section('content')
@if(request()->session()->has('registered'))
<div class="form-group">
    <div class="alert alert-success">
        <ul class="list-group">
            {{ session('registered') }}
        </ul>
    </div>
</div>
@endif
@if(request()->session()->has('notify'))
<div id='notify'>
    <input type="hidden" value="{{ session('notify') }}">
</div>
@endif

<div class="form-group" class="ajax_errors">
    <div class="alert alert-danger">
        <ul class="list-group" id="errors">
        </ul>
    </div>
</div>

<div class="card card-default">
    <div class="card-header bg-success text-dark">
        Employee Record
    </div>
    <div class="card-body">

        <table class="table" width="100%" id="employeeData">
            <thead>
                <th>First Name:</th>
                <th>Last Name:</th>
                <th>Company Name:</th>
                <th>Email:</th>
                <th>Phone:</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">View Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateEmployee" enctype="multipart/form-data" class="form">
                            <div class="form-group" readonly>
                                <label for="fname" class="col-form-label">First Name:</label>
                                <input type="text" class="form-control" id="fname" name="first_name">
                            </div>
                            <div class="form-group">
                                <label for="lname" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="last_name">
                            </div>
                            <div class="form-group">
                                <label for="company_id" class="">Company:</label>
                                <select name="company" id="company_id" class="form-control" required>
                                    <option>---Select The Company----</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Phone:</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="updateEmployeeData" data-dismiss="modal">Update</button>
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
     if($('#notify').is(':visible')){
        x=$('#notify input').val()
        var audio = new Audio("{{asset('storage/sound/swiftly.mp3')}}"); 
        audio.play(); 
        new Notification(`Succesfully registered the employee`,{
            body:`Employee name: ${x}`,
        });
    }
    // Server side rendering using datatables! 
    $(document).ready(function() {
        $.noConflict();
        $('.alert-danger').hide();
        $('#employeeData').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 10,
            "lengthMenu": [10],
            "ajax": "{{ route('employee.index') }}",
            "columns": [{
                    data: "first_name",
                    name: "first_name"
                },
                {
                    data: "last_name",
                    name: "last_name"
                },
                {
                    data: "company_name",
                    name: "company_name"
                },
                {
                    data: "email",
                    name: "email"
                },
                {
                    data: "phone",
                    name: "phone"
                },
                {
                    data: "action",
                    name: "action",
                    orderable: false
                }
            ]
        });
    });

    // Set the modal with Employee Data
    var self_id, tr, fname, lname, curr_comp, email, phone, company_id;
    $(document).on('click', 'button[name="edit"]', function(e) {
        var companies = @json($company_data);
        self_id = $(this).attr('id');
        tr = $(this).parent().parent();
        fname = tr.find('td:eq(0)').text();
        lname = tr.find('td:eq(1)').text();
        curr_comp = tr.find('td:eq(2)').find('b');
        email = tr.find('td:eq(3)').text();
        phone = tr.find('td:eq(4)').text();
        company_id = curr_comp.attr('id');
        $('#myModal #fname').val(fname);
        $('#myModal #lname').val(lname);
        $('#myModal #email').val(email);
        $('#myModal #phone').val(phone);
        $("#myModal #company_id").empty();
        for (var item in companies) {
            if (companies[item].id == company_id) {
                $("#myModal #company_id").append(new Option(companies[item].name, companies[item].id, true, true));
            } else {
                $("#myModal #company_id").append(new Option(companies[item].name, companies[item].id));
            }
        }
    });
    //Update the employee data
    $('#updateEmployeeData').on('click', function(e) {
        console.log(self_id)
        e.preventDefault();
        var formData = new FormData($('#updateEmployee')[0]);
        // console.log(formData.get('company'));
        $.ajax({
            url: `/employee/update/${self_id}`,
            type: 'POST',
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function(obj) {
                location.reload()
                alert('Employee Data Updated Succesfully!')
            },
            error: function(error) {
                $('.alert-danger .list-group').empty()
                $('.alert-danger').show();
                temp_err = error['responseJSON']['errors']
                for (const err in temp_err) {
                    $('#errors').append('<li class="list-group-item">' + temp_err[err][0] + '</li>')
                    console.log(temp_err[err][0]);
                }
            }
        });
    });


    //Delete Employee Data
    $(document).on('click', 'button[name="delete"]', function(e) {
        id = $(this).attr('id');
        $.ajax({
            url: `/employee/delete/${id}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(e) {
                alert('Employee Deleted Succesfully!')
                location.reload();
            },
            error: function(error) {
                console.log(JSON.stringify(error));
            }
        });
    });
</script>
@endsection