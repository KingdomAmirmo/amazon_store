<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostCategoryRequest;
use App\Models\Content\PostCategory;
use App\Http\Services\Image\ImageService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('can:show-category')->only(['index']);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $user = auth()->user();
//        if ($user->can('show-category'))
//        {


//            $postCategories = PostCategory::orderBy('created_at', 'desc')->simplePaginate(15);
//            return view('admin.content.category.index', compact('postCategories'));

//        } else {
//            abort(403);
//        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //using image cache
//        $imageCache = new ImageCacheService();
//        return $imageCache->cache('3.jpg');
        return view('admin.content.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCategoryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            //1
//            $result = $imageService->save($request->image('image'));
            //2
//            $result = $imageService->fitAndSave($request->image('image'), 600, 150);
//            exit();
            //3
            $result = $imageService->createIndexAndSave($request->file('image'));
        }
        if ($result === false)
        {
            return redirect()->route('admin.content.category.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
        }
        $inputs['image'] = $result;
        $postCategory = PostCategory::create($inputs);
        return redirect()->route('admin.content.category.index')->with('swal-success', "دسته بندی شما با موفقیت ثبت شد");

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
    public function edit(PostCategory $postCategory)
    {
        return view('admin.content.category.edit', compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService  $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image'))
        {
            if (!empty($postCategory->image))
            {
                $imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false)
            {
                return redirect()->route('admin.content.category.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
            }
            $inputs['image'] = $result;
        }

        else
        {
            if (isset($inputs['currentImage']) && !empty($postCategory->image))
            {
                $image = $postCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        //برای اینکه هنگام آپدیت عنوان اسلاگ هم تغییر پیدا کنه کد زیر را باید اجرا کنیم
//        $inputs['slog'] = null;
        $postCategory->update($inputs);
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی شما با موفقیت ویرایش شد');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCategory $postCategory)
    {
        $result = $postCategory->delete();
        return redirect()->route('admin.content.category.index')->with('swal-success', 'دسته بندی با موفقیت حذف شد');
    }

    public function status(PostCategory $postCategory){

        $postCategory->status = $postCategory->status == 0 ? 1 : 0;
        $result = $postCategory->save();
        $postCategory->status == 1 ? ($status = "فعال") : ($status = "غیرفعال");
        return redirect()->route('admin.content.category.index')->with('swal-success', "دسته بندی مورد نظر " . $status . " شد");

//        $postCategory->status = $postCategory->status == 0 ? 1 : 0;
//        $result = $postCategory->save();
//        if ($result){
//            if ($postCategory->status == 0){
//                return response()->json(['status' => true, 'checked' => false]);
//            }
//            else{
//                return response()->json(['status' => true, 'checked' => true]);
//
//            }
//        }
//        else{
//            return response()->json(['status' => false]);
//        }

    }

}
