<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Subscription;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Show the application dashboard.
     * @return Application|Factory|RedirectResponse|View
     */
    public function index()
    {
        if (Auth::user()->hasRole(Role::USER)) {
            if (!Auth::user()->fancy_number) {
                return redirect()->route('admin.users.create_fancy', Auth::id());
            }

            $dashboard_info = (new UserService(Auth::user()))->dashboardInfo();

            return view('admin.dashboard', $dashboard_info);
        }

        $users = User::countByRole();

        return view("admin.dashboard-admin", compact('users'));
    }
}
