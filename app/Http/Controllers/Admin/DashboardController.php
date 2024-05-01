<?php

namespace App\Http\Controllers\Admin;

use App\Models\Srequest;
use App\Models\Student;
use App\Models\Employee;

use App\Http\Controllers\Controller;
use App\Traits\AuthUserTrait;
use App\Traits\GeneralTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use AuthUserTrait, GeneralTrait;

    const MAIN_NAV = 'Dashboard';
    const SUB_NAV = '';
    const VIEW_DIR = 'admin.dashboard.';


    public function __construct()
    {
        $this->setSidebarActiveLink(self::MAIN_NAV, self::SUB_NAV);
    }


    public function index(Request $request): View
    {
        $total_requests  = Srequest::count();
        $total_employees = Employee::count();
        $total_students  = Student::count();

        // table params
        $table_params = [
            'dashboard' => true
        ];
        return view(self::VIEW_DIR . 'index', compact('total_requests', 'total_employees', 'total_students'));
    }
}
