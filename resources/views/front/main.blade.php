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
            <div class="mainvisual" x-data="postMainSlide()" x-init="fetchMainSlide()">
                <div class="pc swiper-container swiper-mv">
                    <div class="swiper-wrapper">
                        <template x-for="slide in slideItems" :key="slide.id">
                            <div class="swiper-slide"><a href="#none"><img :src="slide.pc_image" alt="Brand"></a></div>
                        </template>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="sp swiper-container swiper-mv">
                    <div class="swiper-wrapper">
                        <template x-for="slide in slideItems" :key="slide.id">
                            <div class="swiper-slide"><a href="#none"><img :src="slide.mobile_image" alt="Brand"></a></div>
                        </template>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <p class="bar-gray">Creating a healthier way of living</p>
            <!-- /Main Visual -->

            <div id="mainContent">

                <!-- 주요안내 -->
                <section class="important-news" x-data="postNotice()" x-init="fetchNotice()">
                    <h2 class="border-red"><span class="cmn-icon icon-svg icon-exclamation"></span>주요안내</h2>
                    <ul class="important-news-content">
                        <template x-for="notice in notices" :key="notice.id">
                            <li>
                                <a :href="notice.link_url" target="_blank">
                                    <p class="important-news-ttl"><span class="cmn-icon icon-arrow -r"></span><span x-text="notice.title"></span></p>
                                    <p class="important-news-txt" x-text="notice.content"></p>
                                </a>
                            </li>
                        </template>
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data("postMainSlide", () => ({
                slideItems: [],
                swiperInstance: null,
                init() {
                    this.fetchMainSlide();
                },
                fetchMainSlide() {
                    axios.post('/api/admin/banners/list', {
                        is_active: 1
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        this.slideItems = response.data.data;

                        this.$nextTick(() => {
                            this.initSwiper();
                        });
                    }).catch(error => {
                        console.error('메인 슬라이드 목록을 불러오는데 실패했습니다.', error);
                    });
                },
                initSwiper() {
                    // 이미 인스턴스가 있다면 파괴 후 재설정 (데이터 갱신 대비)
                    if (this.swiperInstance) {
                        this.swiperInstance.destroy();
                    }

                    this.swiperInstance = new Swiper('.swiper-container.swiper-mv', {
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
                },
            }));

            Alpine.data("postNotice", () => ({
                notices:[],
                init() {
                    this.fetchNotice();
                },
                fetchNotice() {
                  axios.post("/api/admin/notices/list", {
                      is_active: 1
                  }, {
                      headers: { 'Content-Type': 'application/json' }
                  }).then(response => {
                      this.notices = response.data.data;

                  }).catch(error => {
                      console.error('주요뉴스 목록을 불러오는데 실패했습니다.', error);
                  })
                },
            }));
        });
    </script>
</x-front.layout>
