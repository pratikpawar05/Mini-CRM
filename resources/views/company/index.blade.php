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
        <ul class="list-group">
            {{ session('registered') }}
        </ul>
    </div>
</div>
@endif
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
                <th>Action:</th>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $.noConflict();
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
                    data: "action",
                    name: "action",
                    orderable: false
                }
            ]
        });
    });
</script>

@endsection