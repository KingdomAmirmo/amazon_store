@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد دسترسی</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران </a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">دسترسی ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد دسترسی </li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ایجاد دسترسی </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.permission.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.permission.store') }}" method="Post" id="form">
                        @csrf
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام دسترسی</label>
                                    <input type="text" name="name" class="form-control form-control-sm" value="{{old('name')}}">
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
                                    <label for="">توضیحات دسترسی</label>
                                    <input type="text" name="description" class="form-control form-control-sm" value="{{old('description')}}">
                                </div>
                                @error('description')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" class="form-control form-control-sm" id="status">
                                        <option value="0" @if(old('status') == 0) selected @endif>غیرفعال</option>
                                        <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                    </select>
                                </div>
                                @error('status')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-2">
                                <button type="submit" class="btn btn-primary btn-sm mt-4">ثبت</button>
                            </section>


                        </section>
                    </form>
                </section>


            </section>
        </section>
    </section>


@endsection
