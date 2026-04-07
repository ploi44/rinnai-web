<x-front.layout>
    <x-slot:head>
        <x-front.head-sub>
            <x-slot:title>{{ setting("site_name", "Rinnai") }}</x-slot:title>
        </x-front.head-sub>
    </x-slot:head>

    <main id="mainContent">
        <ol class="bread-list">
            <li><a href="/">Home</a></li>
            <li><a href="#none">린나이 소식</a></li>
            <li>언론보도</li>
        </ol>
        <article id="news">
            <h1 class="bar-gray">영상 콘텐츠</h1>
            <section class="information">
                <div class="padding10"></div>
                <p class="lead col_bot_txt_a">
                    린나이의 이야기가 담긴 다양한 소식들과 홍보 영상, 캠페인 등 따듯한 브랜드 스토리를 바로 만나볼 수 있습니다.
                </p>
                <div class="padding20"></div>
                <div>
                    <a class="border-btn" href="https://www.youtube.com/@rinnaikorea" target="_blank">
                        <span class="cmn-icon icon-arrow -r"></span>린나이 공식 유튜브 채널로 이동<span class="cmn-icon icon-svg icon-external" aria-label="Open an external link"></span>
                    </a>
                </div>
                <div class="padding40"></div>
                <ul class="l-row news -pic">
                    @foreach($posts as $post)
                    <li class="l-col-4 l-col-tb-6 l-col-sm-12">
                        <a href="{{ $post->attachments["youtube_url"] }}" target="_blank" >
                            <figure>
                                <div class="y_shorts_thum_box">
                                    <div class="in_img">
                                        <img src="{{ $post->thumbnail }}" alt="린나이 쇼츠 썸네일">
                                    </div>
                                </div>
                            </figure>
                            <p class="yt_ht_set"><span class="cmn-icon icon-arrow -r"></span><span class="col_bot_txt_b">{{ $post->title }}</span></p>
                            <p class="title col_bot_txt">{{ $post->attachments["youtube_tag"] }}</p>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </section>
            <div class="padding40"></div>
        </article>
    </main>
</x-front.layout>
