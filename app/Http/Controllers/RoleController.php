<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view', 'roles');
        return RoleResource::collection(Role::all());
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
        Gate::authorize('edit', 'roles');
        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($request->input('permissions')) {
            $permissions = $request->input('permissions');
            foreach ($permissions as $permission_id) {
                DB::table('role_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }

        return $request->name . " Role Created Successfully";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::find(($id));
        return new RoleResource($role);
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
        Gate::authorize('edit', 'roles');
        $role = Role::find($id);
        $role->update($request->only('name'));

        DB::table('role_permissions')->where('role_id', $role->id)->delete();

        if ($request->input('permissions')) {
            $permissions = $request->input('permissions');
            foreach ($permissions as $permission_id) {
                DB::table('role_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id,
                ]);
            }
        }

        return $role->name . " Role Update Successfully";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('edit', 'roles');
        $role = Role::find($id);
        RolePermission::where('role_id', $role->id)->delete();
        Role::destroy($role->id);
        return $role->name . " delete Successfully";
    }
}
