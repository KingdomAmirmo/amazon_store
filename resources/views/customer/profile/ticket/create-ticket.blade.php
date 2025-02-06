@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>افزودن تیکت جدید</title>
@endsection


@section('content')




    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">


                @include('customer.layouts.partials.profile-sidebar')


                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>افزودن تیکت</span>
                                </h2>
                                <section class="content-header-link my-2">
                                    <a class="btn btn-danger text-white" href="{{ route('customer.profile.my-tickets') }}">بازگشت</a>
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->



                        <section class="my-3">
                            <form action="{{ route('customer.profile.my-tickets.store') }}" method="Post" enctype="multipart/form-data">
                                @csrf
                                <section class="row">


                                    <section class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="" class="my-2">عنوان :</label>
                                            <input class="form-control form-control-sm" name="subject" id="" value="{{ old('subject') }}">
                                        </div>
                                        @error('subject')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                        @enderror

                                    </section>

                                    <section class="col-12 col-md-4">
                                        <div class="">
                                            <label for="" class="my-2">انتخاب دسته :</label>
                                            <select name="category_id" id="" class="form-control form-control-sm">
                                                <option>دسته را انتخاب کنید</option>
                                                @foreach($ticketCategories as $ticketCategory)
                                                    <option value="{{ $ticketCategory->id }}" @if(old('category_id') == $ticketCategory->id) selected @endif>
                                                        {{ $ticketCategory->name }}
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

                                    <section class="col-12 col-md-4">
                                        <div class="">
                                            <label for="" class="my-2">انتخاب اولویت :</label>
                                            <select name="priority_id" id="" class="form-control form-control-sm">
                                                <option>دسته را انتخاب کنید</option>
                                                @foreach($ticketPriorities as $ticketPriority)
                                                    <option value="{{ $ticketPriority->id }}" @if(old('priority_id') == $ticketPriority->id) selected @endif>
                                                        {{ $ticketPriority->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('priority_id')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>



                                    <section class="col-12">
                                        <div class="form-group">
                                            <label for="" class="my-2">متن :</label>
                                            <textarea class="form-control form-control-sm" name="description" id="" cols="30" rows="4">{{ old('description') }}</textarea>
                                        </div>
                                        @error('description')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                        @enderror

                                    </section>


                                    <section class="col-12 mt-1">
                                        <div class="form-group">
                                            <label for="file" class="my-2">فایل ضمیمه :</label>
                                            <input type="file" class="form-control form-control-sm" name="file" id="file">
                                        </div>
                                        @error('file')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>


                                    <section class="col-12 mt-1">
                                        <button type="submit" class="btn btn-primary btn-sm my-3">ثبت</button>
                                    </section>

                                </section>
                            </form>

                        </section>


                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->


@endsection


