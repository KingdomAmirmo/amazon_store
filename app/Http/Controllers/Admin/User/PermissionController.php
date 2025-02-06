<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\PermissionRequest;
use App\Models\User\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.user.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $inputs = $request->all();
        $permission = Permission::create($inputs);
        return redirect()->route('admin.user.permission.index')->with('swal-success', "دسترسی جدید با موفقیت ثبت شد");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.user.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $permission)
    {
        $inputs = $request->all();
        $permission->update($inputs);
        return redirect()->route('admin.user.permission.index')->with('swal-success', "دسترسی شما با موفقیت ویرایش شد");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $result = $permission->delete();
        return redirect()->route('admin.user.permission.index')->with('swal-success', 'دسترسی مورد نظر با موفقیت حذف شد');

    }

    public function status(Permission $permission)
    {

        $permission->status = $permission->status == 0 ? 1 : 0;
        $result = $permission->save();
        $permission->status == 1 ? ($status = "فعال") : ($status = "غیرفعال");
        return redirect()->route('admin.user.permission.index')->with('swal-success', "دسترسی مورد نظر " . $status . " شد");

    }
}
