@extends('layouts.auth')
@section('content')
    <x-admin.section-header label="student:plural">
        <x-form.button-link name="student_add" route="students.create" icon="fas fa-plus" />
    </x-admin.section-header>

    <x-admin.page>       
        <x-slot:filters>
            <x-admin.form-inline id="search-users-filter" route="users.index" submit_btn_text="filter" method="get">
                <x-form.select name="department_id"
                    label="department"
                    form_group_class="mr-4"
                    empty_first="true"
                    :inline="false"
                    :list="$departments"
                    :value="request('department_id')" />
                <x-form.select name="program_id"
                    label="program"
                    form_group_class="mr-4"
                    empty_first="true"
                    :inline="false"
                    :list="$programs"
                    :value="request('program_id')" />
                <x-form.select name="subject_id"
                    label="subject"
                    form_group_class="mr-4"
                    empty_first="true"
                    :inline="false"
                    :list="$subjects"
                    :value="request('subject_id')" />
            </x-admin.form-inline>
        </x-slot:filters>

        <x-admin.data-table id="students-table" route="students.index" :columns="\App\Models\Student::getColumns()">
            <th>{{ label('student_no') }}</th>
            <th>{{ label('last_name') }}</th>
            <th>{{ label('first_name') }}</th>
            <th>{{ label('middle_name') }}</th>
            <th>{{ label('gender') }}</th>
            <th>{{ label('email') }}</th>
            <th>{{ label('mobile') }}</th>
            <th>{{ label('created_at') }}</th>
            <th>{{ label('action') }}</th>
        </x-admin.data-table>
    </x-admin.page>

    @include('layouts.modals.delete')    
@endsection