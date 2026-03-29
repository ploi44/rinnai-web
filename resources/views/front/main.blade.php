<x-front.layout>
    <x-slot:head>
        <x-front.head-main>
            <x-slot:title>RINNAI</x-slot:title>
        </x-front.head-main>
    </x-slot:head>

    <main id="main">

        <!-- Top page template -->
        <div id="top">

            <!-- Main Visual -->
            <div class="mainvisual">
                <div class="pc swiper-container swiper-mv">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main01.jpg" alt="Brand"></a></div>
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main02.jpg" alt="Brand"></a></div>
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main03.jpg" alt="Brand"></a></div>
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main04.jpg" alt="Brand"></a></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="sp swiper-container swiper-mv">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main01_sp.jpg" alt="Brand"></a></div>
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main02_sp.jpg" alt="Brand"></a></div>
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main03_sp.jpg" alt="Brand"></a></div>
                        <div class="swiper-slide"><a href="#none"><img src="../assets/images/top/main04_sp.jpg" alt="Brand"></a></div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <script>
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
                </script>
            </div>
            <p class="bar-gray">Creating a healthier way of living</p>
            <!-- /Main Visual -->

            <div id="mainContent">

                <!-- 주요안내 -->
                <section class="important-news">
                    <h2 class="border-red"><span class="cmn-icon icon-svg icon-exclamation"></span>주요안내</h2>
                    <ul class="important-news-content">
                        <li>
                            <a href="/dummy/">
                                <p class="important-news-ttl"><span class="cmn-icon icon-arrow -r"></span>린나이몰 방문하기</p>
                                <p class="important-news-txt">새로워진 린나이몰이 리뉴얼 오픈했습니다. 더 편리해진 쇼핑 환경과 함께 린나이 멤버십 혜택을 강화해 다양한 할인·적립 등 알찬 혜택을 제공해드립니다. <br>앞으로도 다채로운 프로모션으로 고객 여러분과 더 가까이 만나겠습니다.</p>
                            </a>
                        </li>
                        <li>
                            <a href="/dummy/">
                                <p class="important-news-ttl"><span class="cmn-icon icon-arrow -r"></span>방문 수리 종료 안내</p>
                                <p class="important-news-txt">기능성(내부)부품 판매 중단 및 센터 방문 수리 종료 안내</p>
                            </a>
                        </li>
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
                                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/pJZT1VeT5S8?autoplay=1&mute=1&rel=0&loop=1&playlist=pJZT1VeT5S8"
                                            title="[린나이] 2026 | 자동조리 레인지 : &#39;요리 중에도 삶은 계속되니까&#39; 남자편(30초)" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                    </iframe>
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
                        <li class="l-col-3 l-col-tb-6 l-col-sm-12">
                            <a href="/dummy.pdf" target="_blank">
                                <figure><img src="../assets/images/main/ex_img_main_nw_1.jpg" alt="린나이소식">
                                </figure>
                                <p><span class="cmn-icon icon-arrow -r"></span><span class="lt_text">25L 전기복합오븐 출시로 라이프스타일 스펙트럼 확장</span></p>
                                <!-- <p><span class="cmn-icon icon-arrow -r"></span><time datetime="Year-Month-Date">Month Date, Year</time><span class="category"><em>Category</em></span></p> -->
                                <!-- <p class="title">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<span class="cmn-icon icon-svg icon-pdf" aria-label="Download PDF file"></span></p> -->
                            </a>
                        </li>
                        <li class="l-col-3 l-col-tb-6 l-col-sm-12">
                            <a href="/dummy/">
                                <figure><img src="../assets/images/main/ex_img_main_nw_2.jpg" alt="린나이소식"></figure>
                                <p><span class="cmn-icon icon-arrow -r"></span><span class="lt_text">상업용 튀김기 안전수칙 안내영상 제작, 배포</span></p>
                            </a>
                        </li>
                        <li class="l-col-3 l-col-tb-6 l-col-sm-12">
                            <a href="/dummy/">
                                <figure><img src="../assets/images/main/ex_img_main_nw_3.jpg" alt="린나이소식"></figure>
                                <p><span class="cmn-icon icon-arrow -r"></span><span class="lt_text">신제품출시!! 자동조리 기술 탑재한 프리미엄 가스레인지 선보여</span></p>
                            </a>
                        </li>
                        <li class="l-col-3 l-col-tb-6 l-col-sm-12">
                            <a href="/dummy.pdf" target="_blank">
                                <figure><img src="../assets/images/main/ex_img_main_nw_4.jpg" alt="린나이소식"></figure>
                                <p><span class="cmn-icon icon-arrow -r"></span><span class="lt_text">제18회 CEO서버스 나이트 행사 지원</span></p>
                            </a>
                        </li>
                    </ul>
                    <p class="btn-txt"><a class="border-btn" href="/dummy/"><span class="cmn-icon icon-arrow -r"></span>List</a></p>

                </section>
                <!-- /린나이 소식 -->

            </div>
        </div>
        <!-- /Top page template -->

    </main>
</x-front.layout>
