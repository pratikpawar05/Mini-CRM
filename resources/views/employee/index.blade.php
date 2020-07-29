@extends('layouts/app')
@section('add')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('employee.create') }}" class="btn btn-success">Add Employee</a>
</div>
@endsection
@section('content')
<div class="card card-default">
    <div class="card-header">
        Categories
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <th>Name:</th>
                <th>View:</th>
                <th>Update:</th>
                <th>Delete:</th>

            </thead>
            <tbody>
        
                @foreach($employee_data as $data)
                <tr>
                    <td>{{ $data->name }}</td>
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