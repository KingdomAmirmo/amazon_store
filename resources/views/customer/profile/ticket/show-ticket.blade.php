@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>تیکت های شما</title>
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
                                    <span>تاریخچه تیکت ها</span>
                                </h2>
                                <section class="content-header-link my-2">
                                    <a class="btn btn-danger text-white" href="{{ route('customer.profile.my-tickets') }}">بازگشت</a>
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->


                        <section class="card my-3">
                            <section class="card-header bg-info text-white">
                                {{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}
                            </section>
                            <section class="card-body">
                                <h5 class="card-title">موضوع : {{ $ticket->subject }}</h5>
                                <p class="card-text">{{ $ticket->description }}</p>
                            </section>
                            @if($ticket->file()->count() > 0)
                                <section class="card-footer">
                                    <a class="btn btn-success" href="{{ asset($ticket->file->file_path) }}" download>دانلود فایل ضمیمه</a>
                                </section>
                            @endif
                        </section>

                        <hr>
                        <div class="border my-2">
                            @foreach($ticket->children as $child)
                                <section class="card m-4">
                                    <section class="card-header bg-primary text-white d-flex justify-content-between">
                                        <div>{{ $child->user->first_name . ' ' . $child->user->last_name }} -
                                        پاسخ دهنده : {{ $child->admin ? $child->admin->user->first_name . ' ' . $child->admin->user->last_name : 'نامشخص' }}
                                        </div>
                                        <div style="font-size: smaller">{{ jalaiDate($child->created_at) }}</div>
                                    </section>
                                    <section class="card-body">
                                        <p class="card-title">{{ $child->description }}</p>
                                    </section>
                                </section>

                            @endforeach
                        </div>

                        <section class="my-3">
                            <form action="{{ route('customer.profile.my-tickets.answer', $ticket->id) }}" method="Post">
                                @csrf
                                <section class="row">

                                    <section class="col-12">
                                        <div class="form-group">
                                            <label for="" class="my-3">پاسخ تیکت</label>
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
