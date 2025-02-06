<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Market\CategoryValueRequest;
use App\Models\Market\CategoryAttribute;
use App\Models\Market\CategoryValue;
use Illuminate\Http\Request;

class PropertyValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryAttribute $category_attribute)
    {
        return view('admin.market.property.value.index', compact('category_attribute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryAttribute $category_attribute)
    {
        return view('admin.market.property.value.create', compact('category_attribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryValueRequest $request, CategoryAttribute $category_attribute)
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $inputs['category_attribute_id'] = $category_attribute->id;
        $value = CategoryValue::create($inputs);
        //changing_type
//        $valueType = CategoryValue::where('id', $value->id)->first();
//        $valueType->update(['type' => $inputs['type']]);
//        dd($valueType->type);

        return redirect()->route('admin.market.value.index', $category_attribute->id)->with('swal-success', 'مقدار فرم کالا شما جدید با موفقیت ثبت شد');

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
    public function edit(CategoryAttribute $category_attribute, CategoryValue $value)
    {
        return view('admin.market.property.value.edit', compact('category_attribute', 'value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryValueRequest $request, CategoryAttribute $category_attribute, CategoryValue $value)
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $inputs['category_attribute_id'] = $category_attribute->id;
        $value->update($inputs);
        return redirect()->route('admin.market.value.index', $category_attribute->id)->with('swal-success', 'مقدار فرم کالا شما جدید با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryAttribute $category_attribute, CategoryValue $value)
    {
        $result = $value->delete();
        return redirect()->route('admin.market.value.index', $category_attribute->id)->with('swal-success', 'مقدار فرم کالا شما با موفقیت حذف شد');

    }
}
