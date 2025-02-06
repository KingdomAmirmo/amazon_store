@extends('admin.layouts.master')

@section('head-tag')
    <title>دسترسی های نقش</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران </a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">نقش ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسترسی های نقش </li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>دسترسی های نقش </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.role.permission-update', $role->id) }}" method="Post" id="form">
                        @csrf
                        @method('put')
                        <section class="row">


                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for=""> عنوان نقش : </label>
                                    <section class="font-weight-bold">{{ $role->name }}</section>
                                </div>
                            </section>

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for=""> توضیح نقش : </label>
                                    <section class="font-weight-bold">{{ $role->description }}</section>
                                </div>
                            </section>



                            <section class="col-12">
                                <section class="row mt-3 py-3">

                                    @php
                                        $rolePermissionArray = $role->permissions->pluck('id')->toArray()
                                    @endphp
                                    @foreach($permissions as $key => $permission)

                                        <section class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" name="permissions[]" id="{{ $permission->id }}"
                                                       value="{{ $permission->id }}" @if(in_array($permission->id, $rolePermissionArray)) checked @endif>
                                                <label for="{{ $permission->id }}" class="form-check-label mr-3 mt-1">{{ $permission->name }}</label>
                                            </div>

                                            <div class="my-2">
                                                @error('permissions.' . $key)
                                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>
                                                        {{ $message }}
                                                    </strong>
                                                    </span>
                                                @enderror
                                            </div>

                                        </section>
                                    @endforeach


                                </section>


                                <section class="col-12 col-md-2">
                                    <button type="submit" class="btn btn-primary btn-sm mt-4">ثبت</button>
                                </section>

                            </section>
                        </section>
                    </form>
                </section>


            </section>
        </section>
    </section>


@endsection
