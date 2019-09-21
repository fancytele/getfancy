<?php

namespace App\Http\Controllers\Admin\Users;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\AgentRequest;
use App\User;

class AgentController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {;
        $users = User::role(Role::Agent)->withTrashed()->get();
        return view('admin.agents.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.agents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AgentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentRequest $request)
    {
        $agent = new User();

        $agent->first_name = $request->first_name;
        $agent->last_name = $request->last_name;
        $agent->email = $request->email;
        //TODO: Generate random password and send One Time Password email
        $agent->password = bcrypt('agent123');

        $agent->save();
        $agent->assignRole(Role::Agent);

        return response()
            ->redirectToRoute('admin.agents.index')
            ->with('alert', ['type' => 'success', 'message' => 'Agent created.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User $agent
     * @return \Illuminate\Http\Response
     */
    public function edit(User $agent)
    {
        return view('admin.agents.edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AgentRequest $request
     * @param  \App\User $agent
     * @return \Illuminate\Http\Response
     */
    public function update(AgentRequest $request, User $agent)
    {
        $agent->first_name = $request->first_name;
        $agent->last_name = $request->last_name;
        $agent->email = $request->email;

        $agent->save();

        return response()->redirectToRoute('admin.agents.index')->with('alert', [
            'type' => 'success',
            'message' => 'Agent updated.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User $agent
     * @return Response
     */
    public function destroy(User $agent)
    {
        $agent->delete();

        return response()->redirectToRoute('admin.agents.index')->with('alert', [
            'type' => 'danger',
            'title' => 'Success',
            'message' => 'Agent inactivated.'
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
        $agent = User::withTrashed()->findOrFail($id);
        $agent->restore();

        return response()->redirectToRoute('admin.agents.index')->with('alert', [
            'type' => 'success',
            'message' => 'Agent restored.'
        ]);
    }

    /**
     * Reset password for the specified resource in storage.
     *
     * @param  \App\User $agent
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(User $agent)
    {
        //TODO: Generate random password and send One Time Password email
        $agent->save(['password', bcrypt('agent123')]);

        return response()->redirectToRoute('admin.agents.index')->with('alert', [
            'type' => 'success',
            'message' => 'Agent password reseted.'
        ]);
    }
}
