@extends('admin.layouts.master')

@section('head-tag')
    <title>نمایش پرداخت</title>
@endsection


@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="#">پرداخت ها </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش پرداخت</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>نمایش پرداخت</h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.market.payment.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section class="card mb-3">
                    <section class="card-header bg-custom-yellow text-white">
                        {{ $payment->user->fullName }} = {{ $payment->user_id }}
                    </section>
                    <section class="card-body">
                        <section class="row">
                            <h5 class="card-title">
                                قیمت : {{ (integer)$payment->paymentable->amount }} تومان
                            </h5>
                            @if($payment->paymentable->gateway)
                                <h5 class="mr-3">
                                    درگاه :  {{ $payment->paymentable->gateway ?? '-' }}
                                </h5>
                            @endif
                        </section>
                        @if($payment->paymentable->transaction_id)
                            <p>
                                شماره پرداخت :  {{ $payment->paymentable->transaction_id ?? '-' }}
                            </p>
                        @endif
                        @if($payment->paymentable->pay_date)
                            <p>
                                تاریخ پرداخت :  {{ jalaiDate($payment->paymentable->pay_date) ?? '-' }}
                            </p>
                        @endif
                        @if($payment->paymentable->cash_receiver)
                            <p>
                                 دریافت کننده :  {{ $payment->paymentable->cash_receiver ?? '-' }}
                            </p>
                        @endif
                    </section>
                </section>



            </section>
        </section>
    </section>


@endsection

