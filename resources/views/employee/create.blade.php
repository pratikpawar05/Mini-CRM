@extends('layouts/app')
@section('content')
<div class="card card-default">
    <div class="card-header label bg-success text-light">
        Add Employee
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="list-group">
                @foreach($errors->all() as $error)
                <li class="list-group-item text-danger">
                    {{ $error }}
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('employee.store') }}" enctype="multipart/form-data" class="form" method="POST">
            @csrf
            <div class="form-group">
                <label for="fname" class="">First Name:</label>
                <input type="text" name="first_name" id="fname" class="form-control">
            </div>
            <div class="form-group">
                <label for="lname" class="">Last Name:</label>
                <input type="text" name="last_name" id="lname" class="form-control">
            </div>
            <div class="form-group">
                <label for="company_id" class="">Company:</label>
                <select name="company" id="company_id" class="form-control" required>
                    <!-- <option>---Select The Company----</option> -->
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="phone" class="">Phone:</label>
                <input id="phone" type="number" name="phone" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Add Employee</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('css/main.css') }}">
@endsection