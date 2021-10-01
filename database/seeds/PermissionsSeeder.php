<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

        foreach ($all_controllers as $key => $row) {
            foreach ($row as $route) {
                $data = [
                    'guard_name' => 'web',
                    'name'       => $key.':'.$route,
                ];

                $permission = Permission::where($data)->first();

                if ($permission == '') {
                    $permission = Permission::create($data);
                }
            }
        }
    }
}
