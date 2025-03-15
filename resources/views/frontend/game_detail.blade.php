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
                <div class="row">
                    <div class="col-md-12">
                        @if ($game->google_drive_url || $game->microsoft_drive_url)
                            <h4 class="text-center mt-3">Download links</h4>

                            @if ($game->google_drive_url)
                                <a href="{{ $game->google_drive_url }}" class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i> Google Drive</a>
                            @endif
                            @if ($game->microsoft_drive_url)
                                <a class="btn btn-primary" href="{{ $game->microsoft_drive_url }}"><i class="fa fa-download" aria-hidden="true"></i> Microsoft Drive</a>
                            @endif
                        @endif
                    </div>


                </div>

            </div>
        </div>
    </section>

    <!-- end service section -->
@endsection
