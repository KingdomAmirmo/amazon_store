@extends('customer.layouts.master-two-col')

@section('head-tag')
    <title>لیست مقایسه های</title>
@endsection


@section('content')




    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success')}}
                    </div>
                @endif


                @include('customer.layouts.partials.profile-sidebar')


                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>لیست مقایسه های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->



                        @if(auth()->user()->compare->products()->count() > 0)
                            <table class="table table-bordered table-responsive ">
                                <tbody>
                                <tr>
                                    <td>عکس محصول</td>
                                    @foreach(auth()->user()->compare->products as $product)
                                            <td>
                                                <a href="{{ route('customer.market.product', $product->slog) }}">
                                                    <img src="{{ asset($product->image['indexArray']['medium']) }}" alt="{{ asset($product->image['indexArray']['medium']) }}" width="100" height="100">
                                                </a>
                                            </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>قیمت محصول</td>
                                    @foreach(auth()->user()->compare->products as $product)
                                        <td>{{ priceFormat($product->price) }} تومان</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>نام محصول</td>
                                    @foreach(auth()->user()->compare->products as $product)
                                        <td>{{ \Illuminate\Support\Str::limit($product->name, 20)  }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>برند محصول</td>
                                    @foreach(auth()->user()->compare->products as $product)
                                        <td>{{ $product->brand->persian_name  }} ({{ $product->brand->original_name }}) </td>
                                    @endforeach
                                </tr>
                                </tbody>

                            </table>
                        @else
                            <h5>محصولی در لیست مقایسه شما وجود ندارد</h5>
                        @endif


                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->











@endsection



@section('script')
    <script>
        $(document).ready(function(){
            bill();
            //input color
            $('input[name="color"]').change(function(){
                bill();
            })
            //guarantee
            $('select[name="guarantee"]').change(function(){
                bill();
            })
            //number
            $('.cart-number').click(function(){
                bill();
            })
        })

        function bill() {
            if($('input[name="color"]:checked').length != 0){
                var selected_color = $('input[name="color"]:checked');
                $("#selected_color_name").html(selected_color.attr('data-color-name'));
            }

            //price computing
            var selected_color_price = 0;
            var selected_guarantee_price = 0;
            var number = 1;
            var product_discount_price = 0;
            var product_original_price = parseFloat($('#product_price').attr('data-product-original-price'));

            if($('input[name="color"]:checked').length != 0)
            {
                selected_color_price = parseFloat(selected_color.attr('data-color-price'));
            }

            if($('#guarantee option:selected').length != 0)
            {
                selected_guarantee_price = parseFloat($('#guarantee option:selected').attr('data-guarantee-price'));
            }

            if($('#number').val() > 0)
            {
                number = parseFloat($('#number').val());
            }

            if($('#product_discount_price').length != 0)
            {
                product_discount_price = parseFloat($('#product_discount_price').attr('data-product-discount-price'));
            }

            //final price
            var product_price = product_original_price + selected_color_price + selected_guarantee_price;
            var final_price = number * (product_price - product_discount_price);
            $('#product_price').html(toFarsiNumber(product_price));
            $('#final_price').html(toFarsiNumber(final_price));
        }


        //JavaScript Helper for englishNumber To farsiNumber
        function toFarsiNumber(number)
        {
            const farsiDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            //add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }
    </script>
@endsection
