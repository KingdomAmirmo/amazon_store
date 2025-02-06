@extends('admin.layouts.master')

@section('head-tag')
    <title>فرم کالا</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش فرم کالا </li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش فرم کالا </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.market.property.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.market.property.update', $category_attribute->id) }}" method="Post">
                        @csrf
                        @method('put')
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام فرم</label>
                                    <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name', $category_attribute->name) }}">
                                </div>
                                @error('name')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                                </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">واحد اندازه گیری</label>
                                    <input type="text" name="unit" class="form-control form-control-sm" value="{{ old('unit', $category_attribute->unit) }}">
                                </div>
                                @error('unit')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                                </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div>
                                    <label for="">انتخاب دسته</label>
                                    <select name="category_id" id="" class="form-control form-control-sm">
                                        <option>دسته را انتخاب کنید</option>
                                        @foreach($productCategories as $productCategory)
                                            <option value="{{ $productCategory->id }}" @if(old('category_id', $category_attribute->category_id) == $productCategory->id) selected @endif>
                                                {{ $productCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
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
