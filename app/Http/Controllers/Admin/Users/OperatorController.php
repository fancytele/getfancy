<?php

namespace App\Http\Controllers\Admin\Users;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\OperatorRequest;
use App\Mail\WelcomeMail;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OperatorController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $operators = User::role(Role::OPERATOR)->withTrashed()->get();
        return view('admin.operators.index', compact('operators'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        return view('admin.operators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OperatorRequest  $request
     * @return Response
     */
    public function store(OperatorRequest $request)
    {
        $operator = new User();

        $operator->first_name = $request->first_name;
        $operator->last_name = $request->last_name;
        $operator->email = $request->email;
        $operator->password = User::generatePassword();

        $operator->save();
        $operator->assignRole(Role::OPERATOR);

        Mail::to($operator)->send(new WelcomeMail($operator));

        return response()
            ->redirectToRoute('admin.operators.index')
            ->with('alert', ['type' => 'success', 'message' => 'Operator created']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $operator
     * @return Response
     */
    public function edit(User $operator)
    {
        return view('admin.operators.edit', compact('operator'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\OperatorRequest  $request
     * @param  \App\User $operator
     * @return Response
     */
    public function update(OperatorRequest $request, User $operator)
    {
        $operator->first_name = $request->first_name;
        $operator->last_name = $request->last_name;
        $operator->email = $request->email;

        $operator->save();

        return response()->redirectToRoute('admin.operators.index')->with('alert', [
            'type' => 'success',
            'message' => 'Operator updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $operator
     * @return Response
     */
    public function destroy(User $operator)
    {
        $operator->delete();

        return response()->redirectToRoute('admin.operators.index')->with('alert', [
            'type' => 'danger',
            'title' => 'success',
            'message' => 'Operator inactivated'
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function restore(int $id)
    {
        $operator = User::withTrashed()->findOrFail($id);
        $operator->restore();

        return response()->redirectToRoute('admin.operators.index')->with('alert', [
            'type' => 'success',
            'message' => 'Operator restored'
        ]);
    }

    /**
     * Reset password for the specified resource in storage.
     *
     * @param  \App\User $operator
     * @return Response
     */
    public function resetPassword(Request $request, User $operator)
    {
        $operator->password = $operator->generatePassword();
        $operator->save();

        $this->sendResetLinkEmail($request);

        return response()->redirectToRoute('admin.operators.index')->with('alert', [
            'type' => 'success',
            'message' => 'Operator password reseted'
        ]);
    }
}
