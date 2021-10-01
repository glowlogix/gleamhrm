<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Traits\MetaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsController extends Controller
{
    use MetaTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->meta['title'] = 'Roles Permissions';

        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.roles_permissions.index', $this->metaResponse())->with([
            'roles'       => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function applyRole()
    {
        $this->meta['title'] = 'Apply Roles to Employee';

        $roles = Role::all();
        $employees = Employee::all();
        $permissions = Permission::all();

        return view('admin.roles_permissions.applyRole', $this->metaResponse())->with([
            'roles'     => $roles,
            'employees' => $employees,
        ]);
    }

    public function applyRolePost(Request $request)
    {
        $role = Role::find($request->role_id);
        $employee = Employee::find($request->employee_id);

        $employee->assignRole($role);
        Session::flash('success', 'Role ('.$role->name.') Assigned employee ('.$employee->firstname.' '.$employee->lastname.') succesfully');

        return redirect()->route('roles_permissions');
    }

    public function checkPermissions($id, $employee_id)
    {
        $emp_permissions = Employee::find($employee_id)->permissions()->get()->pluck('id')->toArray();
        $role = Role::find($id);

        $permissions = $role->permissions()->get();
        $routes = [];

        foreach ($permissions as $key => $permission) {
            $index = explode(':', $permission->name);
            $routes[$index[0]][] = $permission;
        }

        if ($permissions == '[]') {
            $check = 0;
        } else {
            $check = 1;
        }

        return $check;
    }

    public function getPermissionsFromRole($id, $employee_id)
    {
        $emp_permissions = Employee::find($employee_id)->permissions;
        $emp_permissions = $emp_permissions->pluck('id')->toArray();

        $role = Role::find($id);

        $permissions = $role->permissions()->get();
        $routes = [];

        foreach ($permissions as $key => $permission) {
            $index = explode(':', $permission->name);
            $routes[$index[0]][] = $permission;
        }

        return view('admin.roles_permissions.getPermissionsFromRole')->with([
            'role'            => $role,
            'all_controllers' => $routes,
            'emp_permissions' => $emp_permissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->meta['title'] = 'Create Role';

        return view('admin.roles_permissions.create', $this->metaResponse())->with('all_controllers', $this->routesList());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create(['name' => $request->name]);
        if ($request->permissions) {
            foreach ($request->permissions as $value) {
                $val = explode(':', $value);
                $data = [
                    'guard_name' => $val[0],
                    'name'       => $val[1].':'.$val[2],
                ];

                $permission = Permission::where($data)->first();
                if (! isset($permission->id)) {
                    $permission = Permission::create($data);
                }
                $role->givePermissionTo($permission);
            }
        }
        Session::flash('success', 'Role is created successfully');

        return redirect()->route('roles_permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->meta['title'] = 'Update Role';
        $role = Role::find($id);
        $permissions = $role->permissions()->get()->toArray();
        $routes = [];
        foreach ($permissions as $permission) {
            $routes[] = $permission['name'];
        }

        return view('admin.roles_permissions.edit', $this->metaResponse())->with([
            'role'            => $role,
            'routes'          => $routes,
            'all_controllers' => $this->routesList(),
        ]);
    }

    public function routesList()
    {
        $all_controllers = [];
        $routeList = \Route::getRoutes();

        foreach ($routeList as $route) {
            $action = $route->getAction();
            if (isset($action['controller']) && Str::contains($action['controller'], 'Controller@') == true) {
                $row = explode('@', $action['controller']);
                $index = str_replace("App\Http\Controllers\\", '', $row[0]);
                $index = str_replace('Auth\\', '', $index);
                if (
                    $index == 'LoginController' ||
                    $index == 'RegisterController' ||
                    $index == 'ForgotPasswordController' ||
                    $index == 'ResetPasswordController'
                ) {
                    continue;
                }
                $all_controllers[$index][] = $row[1];
            }
        }

        return $all_controllers;
    }

    public function routesListForEmp()
    {
        $all_controllers = [];
        $routeList = \Route::getRoutes();

        foreach ($routeList as $route) {
            $action = $route->getAction();
            if (isset($action['controller']) && Str::contains($action['controller'], 'Controller@') == true) {
                $row = explode('@', $action['controller']);
                $index = str_replace("App\Http\Controllers\\", '', $row[0]);
                $index = str_replace('Auth\\', '', $index);
                if (
                    $index == 'LoginController' ||
                    $index == 'RegisterController' ||
                    $index == 'ForgotPasswordController' ||
                    $index == 'ResetPasswordController'
                ) {
                    continue;
                }
                $all_controllers[$index][] = $row[1];
            }
        }

        return $all_controllers;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        if ($request->permissions) {
            foreach ($request->permissions as $value) {
                $val = explode(':', $value);
                $data = [
                    'guard_name' => $val[0],
                    'name'       => $val[1].':'.$val[2],
                ];

                $permission = Permission::where($data)->first();
                if ($request->permissions_checked != '') {
                    if (in_array($value, $request->permissions_checked)) {
                        if (! isset($permission->id)) {
                            $permission = Permission::create($data);
                        }
                        $role->givePermissionTo($permission);
                    }
                } else {
                    $role->revokePermissionTo($permission);
                }
            }
        }
        Session::flash('success', 'Role is updated successfully');

        return redirect()->route('roles_permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        foreach ($role->permissions as $key => $permission) {
            $role->revokePermissionTo($permission);
        }
        $role->delete();
        Session::flash('success', 'Role and assigned permissions is deleted successfully.');

        return redirect()->back();
    }
}
