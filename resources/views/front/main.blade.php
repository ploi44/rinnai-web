<x-front.layout>
    <x-slot:head>
        <x-front.head-main>
            <x-slot:title>{{ setting("site_name", "Rinnai") }}</x-slot:title>
        </x-front.head-main>
    </x-slot:head>

    <main id="main">

        <!-- Top page template -->
        <div id="top">

            <!-- Main Visual -->
            <div class="mainvisual">
                <div class="pc swiper-container swiper-mv">
                    <div class="swiper-wrapper">
                        @foreach($mainSlides as $slide)
                            <div class="swiper-slide"><a href="#none"><img src="{{ $slide->pc_image }}" alt="Brand"></a></div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="sp swiper-container swiper-mv">
                    <div class="swiper-wrapper">
                        @foreach($mainSlides as $slide)
                            <div class="swiper-slide"><a href="#none"><img src="{{ $slide->mobile_image }}" alt="Brand"></a></div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <p class="bar-gray">Creating a healthier way of living</p>
            <!-- /Main Visual -->

            <div id="mainContent">

                <!-- 주요안내 -->
                <section class="important-news">
                    <h2 class="border-red"><span class="cmn-icon icon-svg icon-exclamation"></span>주요안내</h2>
                    <ul class="important-news-content">
                        @foreach($notices as $notice)
                            <li>
                                <a href="{{ $notice->link_url }}" target="_blank">
                                    <p class="important-news-ttl"><span class="cmn-icon icon-arrow -r"></span>{{ $notice->title }}</span></p>
                                    <p class="important-news-txt">{{ $notice->content }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
                <!-- /주요안내 -->

                <!-- Movie -->
                <section>
                    <h2 class="border-red">Movie</h2>
                    <!-- <h3 class="border-gray">Movie</h3> -->
                    <div class="movie">
                        <div class="inner">
                            <!-- <video controls muted preload="none" playsinline controlsList="nodownload" src="../assets/media/corp/movie/chapter1.mp4" poster="/assets/images/corp/brand/img_brand_chapter01.jpg" width="100%"></video> -->
                            <div class="youtube_area">
                                <div class="sc_box">
                                    @if(getMainYoutubeEmbedUrl() !== "")
                                    <iframe width="100%" height="100%" src="{{ getMainYoutubeEmbedUrl() }}"
                                            title="" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                    </iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /Movie -->


                <!-- 린나이 소식 -->
                <section class="information">
                    <h2 class="border-red">린나이 소식</h2>

                    <ul class="l-row news -pic">
                        @foreach($posts as $post)
                        <li class="l-col-3 l-col-tb-6 l-col-sm-12">
                            <a href="/board/{{ $post->board->slug }}/{{ $post->id }}" target="_blank">
                                <figure><img src="{{ $post->thumbnail }}" alt="린나이소식">
                                </figure>
                                <p><span class="cmn-icon icon-arrow -r"></span><span class="lt_text">{{ $post->title }}</span></p>
                                <!-- <p><span class="cmn-icon icon-arrow -r"></span><time datetime="Year-Month-Date">Month Date, Year</time><span class="category"><em>Category</em></span></p> -->
                                <!-- <p class="title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<span class="cmn-icon icon-svg icon-pdf" aria-label="Download PDF file"></span></p> -->
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <p class="btn-txt"><a class="border-btn" href="/board/rinnaiNews/"><span class="cmn-icon icon-arrow -r"></span>List</a></p>

                </section>
                <!-- /린나이 소식 -->

            </div>
        </div>
        <!-- /Top page template -->

    </main>
    <script>
        $(function() {
            var swiper = new Swiper('.swiper-container.swiper-mv', {
                spaceBetween: 0,
                speed: 500,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        });
    </script>
</x-front.layout>
