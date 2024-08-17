@extends('frontend.layouts.app')

@section('content')
    <section class="service_section layout_padding">
        <div class="service_container">
            <div class="container ">

                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            {!! $game->text !!}
                        </div>
                    </div>

                </div>

                <div class="row">
                    @if ($game->youtube_url)
                        <div class="video-container">
                            <iframe width="650" height="350" src="https://www.youtube.com/embed/{{ $game->youtube_url }}"
                                frameborder="0" allowfullscreen></iframe>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </section>

    <!-- end service section -->
@endsection
