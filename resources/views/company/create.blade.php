@extends('layouts/app')
@section('content')
<div class="card card-default">
    <div class="card-header label bg-success">
        Add Company
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

        <form action="{{ route('company.store') }}" enctype="multipart/form-data" class="form" method="POST">
            @csrf
            <div class="form-group">
                <label for="name" class="">Name:</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="form-group">
                <label for="description">Email:</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="x" class="">Website URL:</label>
                <input id="x" type="text" name="website_url" class="form-control">
            </div>
            <div class="form-group">
                <label for="logo" class="">Logo:</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg text-dark">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
