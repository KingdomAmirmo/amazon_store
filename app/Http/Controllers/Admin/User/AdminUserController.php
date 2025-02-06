<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\AdminUserRequest;
use App\Http\Requests\Admin\User\RoleUserRequest;
use App\Http\Services\Image\ImageService;
use App\Models\User;
use App\Models\User\Role;
use App\Models\User\Permission;
use App\Models\User\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = User::where('user_type', 1)->get();
        return view('admin.user.admin-user.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.admin-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('profile_photo_path')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));

            if ($request === false) {
                return redirect()->route('admin.user.admin-user.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
            }
            $inputs['profile_photo_path'] = $result;
        }
        $inputs['password'] = Hash::make($request->password);
        $inputs['user_type'] = 1;
        $user = User::create($inputs);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', "ادمین جدید با موفقیت ثبت شد");


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
    public function edit(User $admin)
    {
        return view('admin.user.admin-user.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, User $admin, ImageService $imageService)
    {
        $inputs = $request->all();

        if($request->hasFile('profile_photo_path'))
        {
            if(!empty($admin->profile_photo_path))
            {
//                if (!unlink(asset($admin->profile_photo_path))) {
//                    return redirect()->route('admin.user.admin-user.index')->with('swal-error', 'خطا در حذف تصویر');
//                }
                $imageService->deleteImage(public_path($admin->profile_photo_path));
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'users');
            $result = $imageService->save($request->file('profile_photo_path'));
            if($result === false)
            {
                return redirect()->route('admin.user.admin-user.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['profile_photo_path'] = $result;
        }
//        if (!empty($inputs['logo']))
//            $setting->logo = $inputs['logo'];
//        if (!empty($inputs['icon']))
//            $setting->icon = $inputs['icon'];
        $admin->update($inputs);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین سایت شما با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $admin)
    {
        $result = $admin->forceDelete();
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', 'ادمین سایت شما با موفقیت حذف شد');

    }









    public function status(User $user){

        $user->status = $user->status == 0 ? 1 : 0;
        $result = $user->save();
        if($result){
            if($user->status == 0){
                return response()->json(['status' => true, 'checked' => false]);
            }
            else{
                return response()->json(['status' => true, 'checked' => true]);
            }
        }
        else{
            return response()->json(['status' => false]);
        }

    }


    public function activation(User $user){
        $user->activation = $user->activation == 0 ? 1 : 0;
        $result = $user->save();
        if($result){
            if($user->activation == 0){
                return response()->json(['status' => true, 'checked' => false]);
            }
            else{
                return response()->json(['status' => true, 'checked' => true]);
            }
        }
        else{
            return response()->json(['status' => false]);
        }

    }

    public function roles(User $admin)
    {
        $roles = Role::all();
        return view('admin.user.admin-user.role-user.role-user-edit', compact('admin', 'roles'));
    }
    public function rolesStore(RoleUserRequest $request,User $admin)
    {
        $admin->roles()->sync($request->roles);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', "نقش ادمین مورد نظر با موفقیت ویرایش شد");

    }


    public function permissions(User $admin)
    {
        $permissions = Permission::all();
        return view('admin.user.admin-user.permission-user.permission-edit', compact('admin', 'permissions'));
    }
    public function permissionsStore(Request $request,User $admin)
    {
        $validated = $request->validate([
            'permissions' => 'required|array|exists:permissions,id'
        ]);
        $admin->permissions()->sync($request->permissions);
        return redirect()->route('admin.user.admin-user.index')->with('swal-success', "سطح دسترسی ادمین مورد نظر با موفقیت ویرایش شد");

    }




}
