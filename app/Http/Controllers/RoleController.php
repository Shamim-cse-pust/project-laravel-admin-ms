<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Role::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        Role::create([
            'name' => $request->name,
        ]);
        return $request->name . " Role Created Successfully";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find(($id));
        return $role;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $role = Role::find($id);
        // dd($request->all());
        $role->update($request->all());

        return $role->name . " Role Update Successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        Role::destroy($role->id);

        return $role->name . " delete Successfully";
    }
}
