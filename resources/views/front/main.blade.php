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

    <!-- Layer Popups -->
    @if(isset($popups) && $popups->count() > 0)
        @foreach($popups as $popup)
            <div id="layer_popup_{{ $popup->id }}" class="layer-popup" style="position: absolute; left: {{ $popup->position_x }}px; top: {{ $popup->position_y }}px; z-index: 9999; background: #fff; border: 1px solid #ccc; box-shadow: 0 4px 10px rgba(0,0,0,0.1); display: none;">
                <div style="width: {{ $popup->width }}px; height: {{ $popup->height }}px;">
                    @if($popup->link)
                        <a href="{{ $popup->link }}" target="{{ $popup->target ?? '_self' }}" style="display: block; width: 100%; height: 100%;">
                            <img src="{{ $popup->image }}" alt="{{ $popup->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </a>
                    @else
                        <img src="{{ $popup->image }}" alt="{{ $popup->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @endif
                </div>
                <div style="padding: 8px 10px; background: #222; color: #fff; text-align: right; font-size: 13px; display: flex; justify-content: space-between; align-items: center;">
                    <label style="cursor: pointer; display: flex; align-items: center; gap: 5px; margin: 0;">
                        <input type="checkbox" class="popup-today-check" data-id="{{ $popup->id }}"> 오늘 하루 열지 않기
                    </label>
                    <a href="#none" style="color: #fff; text-decoration: none;" onclick="closePopup({{ $popup->id }}); return false;">[닫기]</a>
                </div>
            </div>
        @endforeach

        <script>
            function setCookie(name, value, expiredays) {
                var todayDate = new Date();
                todayDate.setDate(todayDate.getDate() + expiredays);
                document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
            }

            function getCookie(name) {
                var nameOfCookie = name + "=";
                var x = 0;
                while (x <= document.cookie.length) {
                    var y = (x + nameOfCookie.length);
                    if (document.cookie.substring(x, y) == nameOfCookie) {
                        if ((endOfCookie = document.cookie.indexOf(";", y)) == -1)
                            endOfCookie = document.cookie.length;
                        return unescape(document.cookie.substring(y, endOfCookie));
                    }
                    x = document.cookie.indexOf(" ", x) + 1;
                    if (x == 0) break;
                }
                return "";
            }

            function closePopup(id) {
                var $popup = $('#layer_popup_' + id);
                if ($popup.find('.popup-today-check').is(':checked')) {
                    setCookie('popup_' + id, 'done', 1);
                }
                $popup.hide();
            }

            $(function() {
                $('.layer-popup').each(function() {
                    var id = $(this).attr('id').replace('layer_popup_', '');
                    if (getCookie('popup_' + id) !== 'done') {
                        $(this).show();
                    }
                });
            });
        </script>
    @endif
    <!-- /Layer Popups -->

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
