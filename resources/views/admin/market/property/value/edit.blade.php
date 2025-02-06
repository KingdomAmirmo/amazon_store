@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش مقدار فرم کالا</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش مفدار فرم کالا </li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش مقدار فرم کالا </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.market.value.index', $category_attribute->id)}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.market.value.update', ['category_attribute' => $category_attribute->id, 'value' => $value->id]) }}" method="Post">
                        @csrf
                        @method('put')
                        <section class="row">
                            <section class="col-12">
                                <div>
                                    <label for="">انتخاب محصول</label>
                                    <select name="product_id" id="" class="form-control form-control-sm">
                                        <option>محصول را انتخاب کنید</option>
                                        @foreach($category_attribute->category->products as $product)
                                            <option value="{{ $product->id }}" @if(old('product_id', $value->product_id) == $product->id) selected @endif>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('product_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>



                            <section class="col-12 col-md-6 my-4">
                                <div class="form-group">
                                    <label for="">مقدار</label>
                                    <input type="text" name="value" class="form-control form-control-sm" value="{{ old('value', json_decode($value->value)->value) }}">
                                </div>
                                @error('value')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                                </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6 my-4">
                                <div class="form-group">
                                    <label for="">میزان افزایش قیمت </label>
                                    <input type="text" name="price_increase" class="form-control form-control-sm" value="{{ old('price_increase', json_decode($value->value)->price_increase ) }}">
                                </div>
                                @error('price_increase')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="type">نوع</label>
                                    <select name="type" class="form-control form-control-sm" id="type">
                                        <option value="0" @if(old('type', $value->type) == 0) selected @endif>ساده</option>
                                        <option value="1" @if(old('type', $value->type) == 1) selected @endif>انتخابی</option>
                                    </select>
                                </div>
                                @error('type')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>




                            <section class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                        </section>
                    </form>
                </section>


            </section>
        </section>
    </section>


@endsection
