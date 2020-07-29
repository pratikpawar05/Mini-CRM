@extends('layouts/app')
@section('add')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('employee.create') }}" class="btn btn-success">Add Employee</a>
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
<div class="card card-default">
    <div class="card-header">
        Categories
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <th>Employee Name:</th>
                <th>View:</th>
                <th>Update:</th>
                <th>Delete:</th>

            </thead>
            <tbody>
        
                @foreach($employee_data as $data)
                <tr>
                    <td>{{ $data->first_name.$data->last_name }}</td>
                    <td><a href="{{ route('employee.show',$data->id) }}" class="btn btn-info">View</a></td>
                    <td><a href="{{ route('employee.edit',$data->id) }}" class="btn btn-info">Update</a></td>
                    <td>
                        <form action="{{ route('employee.destroy',$data->id) }}" method="post">
                            <input class="btn btn-info" type="submit" value="Delete" />
                            @method('delete')
                            @csrf
                        </form>
                    </td>
                </tr>
                @endforeach
              
            </tbody>
        </table>
    </div>
</div>
@endsection