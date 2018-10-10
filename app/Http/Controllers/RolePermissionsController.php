<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Traits\MetaTrait;
use App\Employee;

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

        return view('admin.roles_permissions.index',$this->metaResponse())->with([
            'roles' => $roles, 
            'permissions' => $permissions,
        ]);
    }

    public function applyRole()
    {
        $this->meta['title'] = 'Apply Roles to Employee';

        $roles = Role::all();
        $employees = Employee::all();
        $permissions = Permission::all();

        return view('admin.roles_permissions.applyRole',$this->metaResponse())->with([
            'roles' => $roles, 
            'employees' => $employees,
        ]);
    }

    public function applyRolePost(Request $request)
    {
        $role = Role::find($request->role_id);
        $employee = Employee::find($request->employee_id);

        $employee->assignRole($role);

        return redirect()->route('roles_permissions')->with('success','Role ('.$role->name.') Assigned employee ('.$employee->firstname.' '.$employee->lastname.') succesfully');      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->meta['title'] = 'Create Role';
        $all_controllers = [];
        
        foreach (Route::getRoutes()->getRoutes() as $route){
            $action = $route->getAction();

            if (array_key_exists('controller', $action)){
                $row = explode('@', $action['controller']);
                $index = str_replace("App\Http\Controllers\\", "", $row[0]);
                $index = str_replace("Auth\\", "", $index);
                $all_controllers[$index][] = $row[1];
            }
        }
        return view('admin.roles_permissions.create',$this->metaResponse())->with('all_controllers', $all_controllers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:roles',
            // 'lastname' => 'required',
        ]);

        $role = Role::create(['name' => $request->name]);
        // dd($request->permissions);
        if ($request->permissions) {
            foreach ($request->permissions as $value) {
                $val = explode(':', $value);
                $data = [
                    'guard_name' => $val[0],
                    'name' => $val[1].':'.$val[2],
                ];

                $permission = Permission::where($data)->first();
                if (!isset($permission->id)) {
                    $permission = Permission::create($data);
                }
                $role->givePermissionTo($permission);
            }
        }

        return redirect()->route('roles_permissions')->with('success','Role is created succesfully');      

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
        $routes=array();
        foreach ($permissions as $permission) {
            $routes[] = $permission['name'];
        }
        $all_controllers = [];
        
        foreach (Route::getRoutes()->getRoutes() as $route){
            $action = $route->getAction();

            if (array_key_exists('controller', $action)){
                $row = explode('@', $action['controller']);
                $index = str_replace("App\Http\Controllers\\", "", $row[0]);
                $index = str_replace("Auth\\", "", $index);
                $all_controllers[$index][] = $row[1];
            }
        }

        return view('admin.roles_permissions.edit',$this->metaResponse())->with([
            'role' => $role,
            'routes' => $routes,
            'all_controllers' => $all_controllers,
        ]);
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
        $role->name=$request->name;
        $role->save();

        if ($request->permissions) {
            foreach ($request->permissions as $value) {
                $val = explode(':', $value);
                $data = [
                    'guard_name' => $val[0],
                    'name' => $val[1].':'.$val[2],
                ];

                $permission = Permission::where($data)->first();
                if (in_array($value, $request->permissions_checked)){
                    if (!isset($permission->id)) {
                        $permission = Permission::create($data);
                    }
                    $role->givePermissionTo($permission);
                }
                else{
                    $role->revokePermissionTo($permission);
                }
            }
        }

        return redirect()->route('roles_permissions')->with('success','Role is updated succesfully');      
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

        return redirect()->back()->with('success','Role and assigned permissions is deleted successfully.');
    }
}
