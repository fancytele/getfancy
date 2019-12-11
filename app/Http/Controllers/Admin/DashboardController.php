<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Services\DIDService;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::user()->hasRole(Role::USER)) {
            $carbon = new Carbon();
            $range = $carbon->firstOfMonth()->format('Y-m-d') . ' to ' . $carbon->today()->format('Y-m-d');
            
            $overview = [
                'total' => 0,
                'successful' => 0,
                'successful_average' => 0,
                'unsuccessful' => 0,
                'unsuccessful_average' => 0,
                'duration' => 0
            ];

            $did_service = new DIDService();
            $fancy_number = Auth::user()->fancy_number; // '50640000229'

            if ($fancy_number) {
                $report = collect($did_service->getCDRReport($fancy_number->did_number, $carbon->year, $carbon->month));

                if ($report->isNotEmpty()) {
                    $total_calls = $report->count();
                    $successful_calls = $report->where('Disconnect Code', 200)->count();
                    $successful_average = number_format(($successful_calls / $total_calls) * 100, 2);

                    $unsuccessful_calls = $total_calls - $successful_calls;
                    $unsuccessful_average = 100 - $successful_average;

                    $overview = [
                        'total' => $total_calls,
                        'successful' => $successful_calls,
                        'successful_average' => $successful_average,
                        'unsuccessful' => $unsuccessful_calls,
                        'unsuccessful_average' => $unsuccessful_average,
                        'duration' => gmdate("i:s",  number_format($report->avg('Duration (secs)')))
                    ];

                    $dashboard['overview'] = $overview;
                }
            }

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
            return view('admin.dashboard', compact('range', 'overview', 'calls'));
        }

        $users = User::countByRole();
        $subscriptions = Subscription::countByProduct();

        return view("admin.dashboard-admin", compact('users', 'subscriptions'));
    }
}
