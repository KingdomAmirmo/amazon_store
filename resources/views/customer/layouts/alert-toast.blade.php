<section class="position-fixed p-4 flex-row-reverse" style="z-index: 9999999;left: 0;top: 15rem;width: 26rem;max-width: 80%">
    <section class="toast" data-delay="7000">
        <section class="toast-header border-bottom bg-gray">
            <h6>فروشگاه آمازون
                <i class="fa fa-store-alt"></i>
            </h6>
        </section>
        <section class="toast-body py-3 d-flex text-dark bg-white rounded-3">
            <strong class="ml-auto">
                برای افزودن کالا به لیست علاقه مندی ها باید ابتدا وارد حساب کاربری خود شوید
                <br>
                <a href="{{ route('auth.customer.login-register-form') }}" class="text-dark">
                    ثبت نام / ورود
                </a>
            </strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </section>
    </section>
</section>
