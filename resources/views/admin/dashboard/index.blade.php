@extends('layouts.auth')
@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row dashboard">
        <x-cards.default name="total_requests" :value="$total_requests" icon="fa fa-comments" border_left_class="secondary" name_color="secondary" />
        <x-cards.default name="total_employees" :value="$total_employees" icon="fa fa-user-secret" border_left_class="secondary" name_color="secondary" />
        <x-cards.default name="total_students" :value="$total_students" icon="fa fa-user" border_left_class="secondary" name_color="secondary" />
    </div>
@endsection