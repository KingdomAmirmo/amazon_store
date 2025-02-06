<?php

namespace Modules\ContentCategory\Http\Controllers;

use App\Http\Services\Image\ImageService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ContentCategory\Entities\PostCategory;
use Modules\ContentCategory\Http\Requests\PostCategoryRequest;

class ContentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $postCategories = PostCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('contentcategory::index', compact('postCategories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('contentcategory::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(PostCategoryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
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
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('contentcategory::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(PostCategory $postCategory)
    {
        return view('contentcategory::edit', compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService $imageService)
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
     * @param int $id
     * @return Renderable
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

    }


}
