<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->hasRole(Role::User)) {
            $faker = \Faker\Factory::create();
            $calls = collect([]);
            
            for ($i = 0; $i < 10; $i++) {
                $calls->add([
                    'started_at' => \Carbon\Carbon::instance($faker->dateTimeThisYear())->toFormattedDateString(),
                    'duration' => $faker->numberBetween(1, 5) . ':' . $faker->numberBetween(1, 60),
                    'source' => $faker->tollFreePhoneNumber,
                    'destination' => 'sip:' . $faker->e164PhoneNumber . '@' . $faker->ipv4,
                    'attemp_number' => $faker->numberBetween(1, 2),
                    'success' => $faker->boolean(90)
                ]);
            }

            $calls = $calls->sortByDesc('started_at')->values();
            return view('admin.dashboard', compact('calls'));
        }

        $users = User::countByRole();

        return view("admin.dashboard-admin", compact('users'));
    }
}
