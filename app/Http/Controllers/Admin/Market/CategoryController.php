<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\ProductCategoryRequest;
use App\Http\Services\Image\ImageService;
use App\Models\Market\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productCategories = ProductCategory::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.market.category.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.market.category.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();

        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            //1
//            $result = $imageService->save($request->image('image'));
            //2
//            $result = $imageService->fitAndSave($request->image('image'), 600, 150);
//            exit();
            //3
            $result = $imageService->createIndexAndSave($request->file('image'));
        }
        if ($request === false)
        {
            return redirect()->route('admin.market.category.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
        }
        $inputs['image'] = $result;
        $productCategory = ProductCategory::create($inputs);
        return redirect()->route('admin.market.category.index')->with('swal-success', "دسته بندی شما با موفقیت ثبت شد");

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
    public function edit(ProductCategory $productCategory)
    {
        $parent_categories = ProductCategory::all()->except($productCategory->id);
        return view('admin.market.category.edit', compact('productCategory', 'parent_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory, ImageService  $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image'))
        {
            if (!empty($productCategory->image))
            {
                $imageService->deleteDirectoryAndFiles($productCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false)
            {
                return redirect()->route('admin.market.category.index')->with('swal-error', "آپلود تصویر با خطا مواجه شد");
            }
            $inputs['image'] = $result;
        }

        else
        {
            if (isset($inputs['currentImage']) && !empty($productCategory->image))
            {
                $image = $productCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        //برای اینکه هنگام آپدیت عنوان اسلاگ هم تغییر پیدا کنه کد زیر را باید اجرا کنیم
//        $inputs['slog'] = null;
        $productCategory->update($inputs);
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته بندی شما با موفقیت ویرایش شد');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        $result = $productCategory->delete();
        return redirect()->route('admin.market.category.index')->with('swal-success', 'دسته بندی با موفقیت حذف شد');

    }


    public function status(ProductCategory $productCategory)
    {
        $productCategory->status = $productCategory->status == 0 ? 1 : 0;
        $result = $productCategory->save();
        $productCategory->status == 1 ? ($status = "فعال") : ($status = "غیرفعال");
        return redirect()->route('admin.market.category.index')->with('toast-success', "دسته بندی مورد نظر " . $status . " شد");
    }

}
