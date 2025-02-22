@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش سطح دسترسی</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران </a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">کاربران ادمین</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش سطح دسترسی </li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش سطح دسترسی </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.admin-user.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('admin.user.admin-user.permissions.store', $admin->id) }}" method="Post" id="form">
                        @csrf
                        <section class="row">

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">نام ادمین:</label>
                                    <h5>{{ $admin->fullName }}</h5>
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
                                <div>
                                    <label for="">دسترسی ها:</label>
                                    <select multiple name="permissions[]" id="select_permissions" class="form-control form-control-sm">
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->id }}" @foreach($admin->permissions as $user_permission)
                                                @if($user_permission->id === $permission->id)
                                                    selected
                                                @endif
                                            @endforeach>
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('permissions')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                <div class="mt-3">
                                    @error('role_id')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                    </span>
                                    @enderror


                                </div>
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


@section('script')
    <script>
        var select_roles = $('#select_permissions');
        select_roles.select2({
            placeholder : "لطفا دسترسی ها را وارد نمایید",
            multiple : true,
            tags : true
        });

    </script>


@endsection
