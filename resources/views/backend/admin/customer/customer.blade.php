@extends('backend.layout.adminmaster')
@section('content')
@section('title')
    Customers - Emerald DMS Dashboard
@endsection
<section class="section">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Live Customers</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="width:100%" id="customers-table">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-light">S.No</th>
                                    <th class="text-light">Name</th>
                                    <th class="text-light">Mobile</th>
                                    <th class="text-light">Zone</th>
                                    <th class="text-light">Last Login</th>
                                    <th class="text-light">Last Activity</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-12 mb-4">
            <div class="h2 page-main-heading">Customers
                Log
            </div>
        </div>
    </div>

    <div class="row mt-3 mb-3">
        <div class="col-md-3">
            <label><b>Select Date Range</b></label>
            <div id="reportrange"
                style="background:#fff; cursor:pointer; padding:8px 10px; border:1px solid #ccc; width:100%">
                <i class="fa fa-calendar"></i>
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
        <div class="col-md-3">
            <label><b>User Filter</b></label>
            <select id="user_filter" class="form-control">
                <option value="all">All Users</option>
                @foreach ($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="width:100%" id="customerslog-table">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-light">S.No</th>
                                    <th class="text-light">Name</th>
                                    <th class="text-light">Mobile</th>
                                    <th class="text-light">Zone</th>
                                    <th class="text-light">Last Login</th>
                                    <th class="text-light">Last Logged Out</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('backend\assets\js\admin\customers\customer.js') }}"></script>
@endsection
