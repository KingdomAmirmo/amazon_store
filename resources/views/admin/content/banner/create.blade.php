@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد بنر</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بنر ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد بنر</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ایجاد بنر</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.content.banner.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.content.banner.store') }}" method="Post" enctype="multipart/form-data" id="form">
                        @csrf
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">عنوان بنر</label>
                                    <input type="text" name="title" class="form-control form-control-sm" value="{{ old('title') }}">
                                </div>
                                @error('title')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div>
                                    <label for="">تصویر</label>
                                    <input type="file" name="image" class="form-control form-control-sm">
                                </div>
                                @error('image')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror

                            </section>

                            <section class="col-12 col-md-6">
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


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">آدرس URL</label>
                                    <input type="text" name="url" class="form-control form-control-sm" value="{{ old('url') }}">
                                </div>
                                @error('url')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">موقعیت</label>
                                    <select name="position" id="" class="form-control form-control-sm">
                                        @foreach($positions as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('position')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 mt-1">
                                <button type="submit" class="btn btn-primary btn-sm">ثبت</button>
                            </section>

                        </section>
                    </form>
                </section>


            </section>
        </section>
    </section>


@endsection

