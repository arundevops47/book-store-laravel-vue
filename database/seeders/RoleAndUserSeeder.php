<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			DB::statement('SET FOREIGN_KEY_CHECKS=0;');
			DB::table('roles')->truncate();
			DB::table('users')->truncate();
			DB::statement('SET FOREIGN_KEY_CHECKS=1;');

			$roles = array(
								array(
									'id' => 1,
									'slug' => 'admin',
									'name' => 'Admin',
									'permission' => 'all',
									'members' => array(
										array(
											'name' => 'Admin',
											'email' => 'admin@admin.com',
											'password' => Hash::make(env('ADMIN_PASSWORD')),										
										)
									)
								),
								array(
									'id' => 2,
									'slug' => 'user',
									'name' => 'User',
									'permission' => '',
								),
							);

			foreach($roles as $key => $val) {
				$role = new Role();
				$role->slug = $val['slug'];
				$role->name = $val['name'];
				$role->permission = $val['permission'];
				$role->created_at = Carbon::now()->format('Y-m-d H:i:s');
				$role->updated_at = Carbon::now()->format('Y-m-d H:i:s');
				$role->save();

				if(isset($val['members']) && count($val['members'])) {
					foreach($val['members'] as $key => $mval) { 
						$user = new User();
						$user->name = $mval['name'];
						$user->email = $mval['email'];
						$user->password = $mval['password'];
						$user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
						$user->role_id = $role->id;
						$user->created_at = Carbon::now()->format('Y-m-d H:i:s');
						$user->updated_at = Carbon::now()->format('Y-m-d H:i:s');						
						$user->save();
					}
				}
			}				

    }
}
