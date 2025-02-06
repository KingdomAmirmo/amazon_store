@extends('contentcategory::layouts.master')

@section('head-tag')
    <title>دسته بندی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسته بندی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسته بندی
                    </h5>
                </section>

                {{-- for alert-section --}}
                {{--                @include('admin.alerts.alert-section.success')--}}

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.content.category.create') }}" class="btn btn-info btn-sm">ایجاد دسته بندی</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام دسته بندی</th>
                            <th>توضیحات</th>
                            <th>اسلاگ</th>
                            <th>عکس</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($postCategories as $key => $postCategory)

                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $postCategory->name }}</td>
                                <td>{{ $postCategory->description }}</td>
                                <td>{{ $postCategory->slog }}</td>
                                <td>
                                    <img src="{{ asset($postCategory->image['indexArray'][$postCategory->image['currentImage']] ) }}" alt="" width="100" height="auto">
                                </td>
                                <td>{{ $postCategory->tags }}</td>
                                <td class="">
                                    <label>
                                        @if ($postCategory->status === 1)
                                            <span class="bg-custom-yellow text-white p-1 btn-sm">فعال</span>
                                        @else
                                            <span class="bg-custom-yellow text-white p-1 btn-sm">غیرفعال</span>
                                        @endif
                                    </label>
                                </td>

                                <td class="width-16-rem text-left">
                                    <form class="d-inline" action="{{ route('admin.content.category.status', $postCategory->id) }}" method="post">
                                        @csrf
                                        {{ method_field('put') }}
                                        @if ($postCategory->status === 0)
                                            <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-check"></i> فعال</button>
                                        @else
                                            <button class="btn btn-warning text-white btn-sm" type="submit"><i class="fa fa-remove"></i> غیر فعال</button>
                                        @endif
                                    </form>

                                    <a href="{{ route('admin.content.category.edit', $postCategory->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> ویرایش</a>
                                    <form class="d-inline" action="{{ route('admin.content.category.destroy', $postCategory->id) }}" method="post">
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




    {{--    with AJAX--}}
    {{--    <script type="text/javascript">--}}
    {{--        function changeStatus(id){--}}
    {{--            var element = $("#" + id)--}}
    {{--            var url = element.attr('data-url')--}}
    {{--            var elementValue = !element.prop('checked');--}}

    {{--            $.ajax({--}}
    {{--                url : url,--}}
    {{--                type : "GET",--}}
    {{--                success : function(response){--}}
    {{--                    if(response.status){--}}
    {{--                        if(response.checked)--}}
    {{--                            element.prop('checked', true);--}}
    {{--                        else--}}
    {{--                            element.prop('checked', false);--}}
    {{--                    }--}}
    {{--                    else{--}}
    {{--                        element.prop('checked', elementValue);--}}
    {{--                    }--}}
    {{--                }--}}
    {{--            })--}}
    {{--        }--}}
    {{--    </script>--}}


@endsection
