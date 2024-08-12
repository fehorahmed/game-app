<section class="slider_section ">
    <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @forelse ($home_sliders as $key => $item)
                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="detail-box">
                                    {!! $item->content !!}
                                    <div class="btn-box">
                                        {{-- <a href="" class="btn1">
                                            Read More
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box">
                                    <img src="{{ asset($item->image) }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty

                <div class="carousel-item active">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="detail-box">
                                    <h1>
                                        Crypto 2<br>
                                        Currency
                                    </h1>
                                    <p>
                                        Explicabo esse amet tempora quibusdam laudantium, laborum eaque magnam
                                        fugiat hic? Esse dicta aliquid error repudiandae earum suscipit fugiat
                                        molestias, veniam, vel architecto veritatis delectus repellat modi impedit
                                        sequi.
                                    </p>
                                    <div class="btn-box">
                                        <a href="" class="btn1">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box">
                                    <img src="{{ asset('frontend') }}/images/slider-img.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="detail-box">
                                    <h1>
                                        Crypto 3 <br>
                                        Currency
                                    </h1>
                                    <p>
                                        Explicabo esse amet tempora quibusdam laudantium, laborum eaque magnam
                                        fugiat hic? Esse dicta aliquid error repudiandae earum suscipit fugiat
                                        molestias, veniam, vel architecto veritatis delectus repellat modi impedit
                                        sequi.
                                    </p>
                                    <div class="btn-box">
                                        <a href="" class="btn1">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box">
                                    <img src="{{ asset('frontend') }}/images/slider-img.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="container ">
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="detail-box">
                                    <h1>
                                        Crypto 4 <br>
                                        Currency
                                    </h1>
                                    <p>
                                        Explicabo esse amet tempora quibusdam laudantium, laborum eaque magnam
                                        fugiat hic? Esse dicta aliquid error repudiandae earum suscipit fugiat
                                        molestias, veniam, vel architecto veritatis delectus repellat modi impedit
                                        sequi.
                                    </p>
                                    <div class="btn-box">
                                        <a href="" class="btn1">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="img-box">
                                    <img src="{{ asset('frontend') }}/images/slider-img.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <ol class="carousel-indicators">
            @forelse ($home_sliders as $key => $item)
                <li data-target="#customCarousel1" data-slide-to="{{ $key }}"
                    class="{{ $key == 0 ? 'active' : '' }}"></li>
            @empty
                <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
                <li data-target="#customCarousel1" data-slide-to="1"></li>
                <li data-target="#customCarousel1" data-slide-to="2"></li>
            @endforelse

        </ol>
    </div>

</section>
