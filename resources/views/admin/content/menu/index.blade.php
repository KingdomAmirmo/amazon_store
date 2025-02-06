@extends('admin.layouts.master')

@section('head-tag')
    <title>منو</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> منو</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>منو</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.content.menu.create') }}" class="btn btn-info btn-sm">ایجاد منو جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستحو...">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام منو</th>
                                <th>منوی والد</th>
                                <th>لینک منو</th>
                                <th>وضعیت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $key => $menu)
                            <tr>
                                <th>{{ ++$key }}</th>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->parent_id ? $menu->parent->name : 'منوی اصلی' }}</td>
                                <td>{{ $menu->url }}</td>
                                <td class="">
                                    <label>
                                        {{-- for change status --}}
                                        <form class="d-inline" action="{{ route('admin.content.menu.status', $menu->id) }}" method="post">
                                            @csrf
                                            {{ method_field('put') }}
                                            @if ($menu->status === 0)
                                                <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check"></i> فعال</button>
                                            @else
                                                <button class="btn btn-warning text-white btn-sm" type="submit"><i class="fa fa-remove"></i> غیر فعال</button>
                                            @endif
                                        </form>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('admin.content.menu.edit', $menu->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"> </i>ویرایش</a>
                                    <form class="d-inline" action="{{ route('admin.content.menu.destroy', $menu->id) }}" method="post">
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

    @include("admin.alerts.sweetalert.delete-confirm", ['className'=> 'delete'])

@endsection
