<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use ZuiHuiGou\Role;
use ZuiHuiGou\User;
use ZuiHuiGou\Permission;
use Illuminate\Support\Facades\Hash;

class EntrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id']);
        });

        // Create table for storing permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
        $this->setupFoundorAndBaseRolsPermission();
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('permissions');
        Schema::drop('role_user');
        Schema::drop('roles');
    }
    public function setupFoundorAndBaseRolsPermission()
    {
        // Create Roles
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = '管理员'; // optional
        $admin->description  = '拥有全部权限。'; // optional
        $admin->save();
        $tenderee = new Role();
        $tenderee->name         = 'tenderee';
        $tenderee->display_name = '招标人'; // optional
        $tenderee->description  = '拥有招标权限。'; // optional
        $tenderee->save();
        $bidder = new Role();
        $bidder->name         = 'bidder';
        $bidder->display_name = '投标人'; // optional
        $bidder->description  = '拥有投标权限。'; // optional
        $bidder->save();
        $ban = new Role();
        $ban->name         = 'ban';
        $ban->display_name = '封禁用户'; // optional
        $ban->description  = '禁止一切操作并屏蔽该用户所有信息。'; // optional
        $ban->save();



        // Create Permissions
        $createDemand = new Permission();
        $createDemand->name         = 'create-demand';
        $createDemand->display_name = '招标'; // optional
        $createDemand->description  = '发布新招标'; // optional
        $createDemand->save();
        $deleteDemand = new Permission();
        $deleteDemand->name         = 'delete-demand';
        $deleteDemand->display_name = '删除招标'; // optional
        $deleteDemand->description  = '删除招标信息'; // optional
        $deleteDemand->save();
        $editDemand = new Permission();
        $editDemand->name         = 'edit-demand';
        $editDemand->display_name = '修改招标';
        $editDemand->description  = '修改招标信息';
        $editDemand->save();
        $viewDemand = new Permission();
        $viewDemand->name         = 'view-demand';
        $viewDemand->display_name = '查看招标';
        $viewDemand->description  = '允许查看其他用户招标信息';
        $viewDemand->save();


        $createBid = new Permission();
        $createBid->name         = 'create-bid';
        $createBid->display_name = '投标'; // optional
        $createBid->description  = '进行投标'; // optional
        $createBid->save();
        $deleteBid = new Permission();
        $deleteBid->name         = 'delete-bid';
        $deleteBid->display_name = '删除投标'; // optional
        $deleteBid->description  = '删除投标信息'; // optional
        $deleteBid->save();
        $editBid = new Permission();
        $editBid->name         = 'edit-bid';
        $editBid->display_name = '修改投标';
        $editBid->description  = '修改所有投标信息';
        $editBid->save();
        $viewBid = new Permission();
        $viewBid->name         = 'view-bid';
        $viewBid->display_name = '查看投标';
        $viewBid->description  = '允许查看其他用户投标信息';
        $viewBid->save();

        $editUser = new Permission();
        $editUser->name         = 'edit-user';
        $editUser->display_name = '修改用户';
        $editUser->description  = '修改其他用户信息';
        $editUser->save();
        $banUser = new Permission();
        $banUser->name         = 'ban-user';
        $banUser->display_name = '封禁用户';
        $banUser->description  = '禁止用户登录';
        $banUser->save();
        $deleteUser = new Permission();
        $deleteUser->name         = 'delete-user';
        $deleteUser->display_name = '删除用户'; // optional
        $deleteUser->description  = '删除用户信息'; // optional
        $deleteUser->save();


        $admin->attachPermission($createDemand, $deleteDemand, $editDemand, $viewDemand, $createBid, $deleteBid, $editBid, $viewBid, $editUser, $banUser, $deleteUser);
        // equivalent to $admin->perms()->sync(array($createPost->id));
        $tenderee->attachPermissions(array($createDemand));
        // equivalent to $owner->perms()->sync(array($createDemand->id, $createBid->id));
        $bidder->attachPermissions(array($createDemand, $createBid));


        // Create User
        $user = new User;
        $user->username = 'admin';
        $user->mobile = '18600000000';
        $user->password = Hash::make('admin');
        $user->save();

        // Attach Roles to user
        $user = User::where('username', '=', 'admin')->first();
        // role attach alias
        $user->attachRole($admin); // parameter can be an Role object, array, or id
        // or eloquent's original technique
        //$user->roles()->attach($admin->id); // id only



        $user = new User;
        $user->username = 'bidder';
        $user->mobile = '18600000001';
        $user->password = Hash::make('111111');
        $user->save();
        $user = User::where('username', '=', 'bidder')->first();
        $user->attachRole($bidder);

        $user = new User;
        $user->username = 'tenderee';
        $user->mobile = '18600000002';
        $user->password = Hash::make('111111');
        $user->save();
        $user = User::where('username', '=', 'tenderee')->first();
        $user->attachRole($tenderee);

    }
}
