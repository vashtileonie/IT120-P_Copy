<ul class="navbar-nav bg-gradient-secondary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon"></div>
        <div class="sidebar-brand-text mx-3">Mapua CSA</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(session()->get('main_nav') == 'Dashboard') active @endif">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - Employees and Students -->
    <li class="nav-item @if(session()->get('main_nav') == 'Academics') active @endif">
        <a class="nav-link @if(session()->get('main_nav') != 'Academics') collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseAcademics" aria-expanded="true" aria-controls="collapseAcademics">
            <i class="fa fa-user-secret" aria-hidden="true"></i>
            <span>Academics</span>
        </a>
        <div id="collapseAcademics" class="collapse @if(session()->get('main_nav') == 'Academics') show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(session()->get('sub_nav') == 'Employees') active @endif" href="{{ route('employees.index') }}">Employees</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Students') active @endif" href="{{ route('students.index') }}">Students</a>
            </div>
        </div>
    </li>
  
    <!-- Nav Item - Transactions -->
    <li class="nav-item @if(session()->get('main_nav') == 'Transactions') active @endif">
        <a class="nav-link @if(session()->get('main_nav') != 'Transactions') collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseTransactions" aria-expanded="true" aria-controls="collapseTransactions">
            <i class="fa =" aria-hidden="true"></i>
            <span>Transactions</span>
        </a>
        <div id="collapseTransactions" class="collapse @if(session()->get('main_nav') == 'Transactions') show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(session()->get('sub_nav') == 'Srequests') active @endif" href="{{ route('srequests.index') }}">Student Requests</a>
            </div>
        </div>
    </li>
    
    <!-- Nav Item - System Users -->
    <li class="nav-item @if(session()->get('main_nav') == 'System Users') active @endif">
        <a class="nav-link @if(session()->get('main_nav') != 'System Users') collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true" aria-controls="collapseUsers">
            <i class="fa fa-user"></i>
            <span>System Users</span>
        </a>
        <div id="collapseUsers" class="collapse @if(session()->get('main_nav') == 'System Users') show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item @if(session()->get('sub_nav') == 'Users') active @endif" href="{{ route('users.index') }}">Users</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Roles') active @endif" href="{{ route('roles.index') }}">Roles</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Permissions') active @endif" href="{{ route('permissions.index') }}">Permissions</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Settings -->
    <li class="nav-item @if(session()->get('main_nav') == 'Settings') active @endif">
        <a class="nav-link @if(session()->get('main_nav') != 'Settings') collapsed @endif" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="true" aria-controls="collapseSettings">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Configurations</span>
        </a>
        <div id="collapseSettings" class="collapse @if(session()->get('main_nav') == 'Settings') show @endif" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item @if(session()->get('sub_nav') == 'Advising Types') active @endif" href="{{ route('advising-types.index') }}">Advising Types</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Departments') active @endif" href="{{ route('departments.index') }}">Departments</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Employee Statuses') active @endif" href="{{ route('employee-statuses.index') }}">Employee Statuses</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Form Types') active @endif" href="{{ route('form-types.index') }}">Form Types</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Priorities') active @endif" href="{{ route('priorities.index') }}">Priorities</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Programs') active @endif" href="{{ route('programs.index') }}">Programs</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Positions') active @endif" href="{{ route('positions.index') }}">Positions</a>
                <a class="collapse-item @if(session()->get('sub_nav') == 'Subjects') active @endif" href="{{ route('subjects.index') }}">Subjects</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
</ul>