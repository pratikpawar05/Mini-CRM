@extends('layouts/app')
@section('add')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('employee.create') }}" class="btn btn-primary">Add Employee</a>
</div>
@endsection
@section('content')
@if(request()->session()->has('registered'))
<div class="form-group">
    <div class="alert alert-danger">
        <ul class="list-group">
            {{ session('registered') }}
        </ul>
    </div>
</div>
@endif
<div id="app">

</div>
<div class="card card-default">
    <div class="card-header bg-success">
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
                    <form>
                        <div class="form-group" readonly>
                            <label for="fname" class="col-form-label">First Name:</label>
                            <input type="text" class="form-control" id="fname">
                        </div>
                        <div class="form-group">
                            <label for="lname" class="col-form-label">Last Name:</label>
                            <input type="text" class="form-control" id="lname">
                        </div>
                        <div class="form-group">
                            <label for="company_id" class="">Company:</label>
                            <select name="company" id="company_id" class="form-control" required>
                                <option>---Select The Company----</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="email">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Phone:</label>
                            <input type="text" class="form-control" id="phone">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateEmployeeData" data-dismiss="modal">Update</button>
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

        $('#employeeData').DataTable({
            "processing": true,
            "serverSide": true,
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
    var self_id,tr,fname,lname,curr_comp,email,phone,company_id;
    $(document).on('click', 'button[name="edit"]', function(e) {
        var companies=@json($company_data);
        self_id=$(this).attr('id');
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
    $.ajax({
        url: `/employee/update/${self_id}`,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            first_name: $('#myModal #fname').val(),
            last_name: $('#myModal #lname').val(),
            company_id: $("#myModal #company_id option:selected").val(),
            email: $('#myModal #email').val(),
            phone: $('#myModal #phone').val(),
        },
        success: function(obj) {
            location.reload()
           
        },
        error: function(error) {
            console.log(JSON.stringify(error));
        }
        });
    });


    //Delete Employee Data
    $(document).on('click', 'button[name="delete"]', function(e) {
        id=$(this).attr('id');
        $.ajax({
        url: `/employee/delete/${id}`,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(e){
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