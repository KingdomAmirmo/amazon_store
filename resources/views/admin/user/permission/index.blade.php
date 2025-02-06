@extends('admin.layouts.master')

@section('head-tag')
    <title>دسترسی ها</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">دسترسی ها</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>دسترسی ها</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.permission.create') }}" class="btn btn-info btn-sm">ایجاد دسترسی جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستحو...">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام دسترسی</th>
                                <th>توضیحات دسترسی</th>
                                <th>نام نقش ها</th>
                                <th>وضعیت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->description }}</td>
                                <td>
                                    @if(empty($permission->roles()->get()->toArray()))
                                        <span class="text-danger">برای این دسترسی هیچ نقشی تعریف نشده است</span>
                                    @else
                                        @foreach($permission->roles as $role)
                                            {{ $role->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="">
                                    <label>
                                        @if ($permission->status === 1)
                                            <span class="bg-custom-yellow text-white p-1 btn-sm">فعال</span>
                                        @else
                                            <span class="bg-custom-yellow text-white p-1 btn-sm">غیرفعال</span>
                                        @endif
                                    </label>
                                </td>
                                <td class="width-18-rem text-left">

                                    <form class="d-inline" action="{{ route('admin.user.permission.status', $permission->id) }}" method="post">
                                        @csrf
                                        {{ method_field('put') }}
                                        @if ($permission->status === 0)
                                            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check"></i> فعال</button>
                                        @else
                                            <button class="btn btn-warning text-white btn-sm" type="submit"><i class="fa fa-remove"></i> غیر فعال</button>
                                        @endif
                                    </form>


                                    <a href="{{ route('admin.user.permission.edit', $permission->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>ویرایش</a>
                                    <form class="d-inline" action="{{ route('admin.user.permission.destroy', $permission->id) }}" method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i class="fa fa-trash-alt"></i> حذف</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>


            </section>
        </section>
    </section>


@endsection

@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection()

