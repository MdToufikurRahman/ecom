<header>
    <div class="container">
        <div class="row align-items-center">

            <!-- LEFT: Contact Info -->
            <div class="col-4">
                <div class="wsus__call_area">
                    <div class="wsus__call_text">
                        <!-- <p>{{$settings->contact_email}}</p>
                        <p>{{$settings->contact_phone}}</p> -->
                        <p>rahman@gmail.com</p>
                        <p>01641902311</p>
                    </div>
                </div>
            </div>

            <!-- MIDDLE: Site Name -->
            <div class="col-4 text-center">
                <h3 class="mb-0 fw-bold">Tofu Corner</h3>
            </div>

            <!-- RIGHT: Wishlist + Cart -->
            <div class="col-4 text-end">
                <ul class="wsus__icon_area justify-content-end">
                    <li>
                        <a href="{{route('user.wishlist.index')}}">
                            <i class="fal fa-heart"></i>
                            <span id="wishlist_count">
                                @if (auth()->check())
                                    {{\App\Models\Wishlist::where('user_id', auth()->user()->id)->count()}}
                                @else
                                    0
                                @endif
                            </span>
                        </a>
                    </li>

                    <li>
                        <a class="wsus__cart_icon" href="#">
                            <i class="fal fa-shopping-bag"></i>
                            <span id="cart-count">{{Cart::content()->count()}}</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <!-- MINI CART (unchanged) -->
    <div class="wsus__mini_cart">
        <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>

        <ul class="mini_cart_wrapper">
            @foreach (Cart::content() as $sidebarProduct)
                <li id="mini_cart_{{$sidebarProduct->rowId}}">
                    <div class="wsus__cart_img">
                        <a href="#">
                            <img src="{{asset($sidebarProduct->options->image)}}" alt="product" class="img-fluid w-100">
                        </a>
                        <a class="wsis__del_icon remove_sidebar_product"
                           data-id="{{$sidebarProduct->rowId}}" href="#">
                            <i class="fas fa-minus-circle"></i>
                        </a>
                    </div>

                    <div class="wsus__cart_text">
                        <a class="wsus__cart_title"
                           href="{{route('product-detail', $sidebarProduct->options->slug)}}">
                            {{$sidebarProduct->name}}
                        </a>
                        <p>{{$settings->currency_icon}}{{$sidebarProduct->price}}</p>
                        <small>Variants total: {{$settings->currency_icon}}{{$sidebarProduct->options->variants_total}}</small><br>
                        <small>Qty: {{$sidebarProduct->qty}}</small>
                    </div>
                </li>
            @endforeach

            @if (Cart::content()->count() === 0)
                <li class="text-center">Cart Is Empty!</li>
            @endif
        </ul>

        <div class="mini_cart_actions {{Cart::content()->count() === 0 ? 'd-none': ''}}">
            <h5>
                sub total
                <span id="mini_cart_subtotal">
                    {{$settings->currency_icon}}{{getCartTotal()}}
                </span>
            </h5>
            <div class="wsus__minicart_btn_area">
                <a class="common_btn" href="{{route('cart-details')}}">view cart</a>
                <a class="common_btn" href="{{route('user.checkout')}}">checkout</a>
            </div>
        </div>
    </div>
</header>
