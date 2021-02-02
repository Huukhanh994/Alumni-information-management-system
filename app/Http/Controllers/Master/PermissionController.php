<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RoleUser;
use App\Models\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('pages.admins.permissions.index')
            ->with('roles',$roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_role_admin()
    {
        $role_admin = Permission::with(['route','role'])->whereHas('role', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();
        //dd($role_teacher);

        return view('pages.admins.permissions.index_role_admin')
            ->with('role_admin',$role_admin);
        
    }


    public function index_role_teacher()
    {
        $role_teacher = Permission::with(['route','role'])->whereHas('role', function ($query) {
            $query->where('role_id', '=', 2);
        })->get();

        return view('pages.admins.permissions.index_role_teacher')
        ->with('role_teacher',$role_teacher);
    }

    public function index_role_alumni()
    {
        $role_alumni = Permission::with(['route','role'])->whereHas('role', function ($query) {
            $query->where('role_id', '=', 3);
        })->get();

        return view('pages.admins.permissions.index_role_alumni')
        ->with('role_alumni',$role_alumni);
    }

    public function index_role_student()
    {
        $role_student = Permission::with(['route','role'])->whereHas('role', function ($query) {
            $query->where('role_id', '=', 4);
        })->get();

        return view('pages.admins.permissions.index_role_student')
        ->with('role_student',$role_student);
    }


    public function create()
    {
        // Xem người dùng đăng nhập vào có phân quyền là gì
        $role_id = Role::with('users')->whereHas('users', function ($query) {
            $query->where('users.user_id', '=', Auth::user()->user_id);
        })->value('role_id');
        // dd($role_id);

        $routes = DB::table('permissions')
            ->rightJoin('routes', 'permissions.route_id', '=', 'routes.route_id')
            ->where('permissions.permission_id','=',null)->get();
        // dd($query);
        return view('pages.admins.permissions.create')
            ->with('routes',$routes)
            ->with('role_id',$role_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission_code = new Permission();
        $permission_code->route_id = $request->get('route_id');
        $permission_code->role_id  = $request->get('role_id');
        //dd($permission_code);

        $permission_code->save();
        return \redirect()->route('permissions/create')->with('success','Thêm route truy cập thành công');

        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $role_id)
    {

        $role_admin = Permission::with(['route','role'])->whereHas('role', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();
        //dd($role_teacher);

        return view('pages.admins.permissions.show')
            ->with('role_admin',$role_admin);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
