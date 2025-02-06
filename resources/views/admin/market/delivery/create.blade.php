@extends('admin.layouts.master')

@section('head-tag')
    <title>روش ارسال</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">روش های ارسال</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد روش ارسال جدید</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ایجاد روش ارسال</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.market.delivery.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.market.delivery.store') }}" method="Post">
                        @csrf
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام روش ارسال</label>
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
                                    <label for="">هزینه روش ارسال</label>
                                    <input type="text" name="amount" class="form-control form-control-sm" value="{{old('amount')}}">
                                </div>
                                @error('amount')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">زمان ارسال</label>
                                    <input type="text" name="delivery_time" class="form-control form-control-sm" value="{{old('delivery_time')}}">
                                </div>
                                @error('delivery_time')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">واحد زمان ارسال</label>
                                    <input type="text" name="delivery_time_unit" class="form-control form-control-sm" value="{{old('delivery_time_unit')}}">
                                </div>
                                @error('delivery_time_unit')
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
