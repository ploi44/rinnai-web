<x-front.layout>
    <x-slot:head>
        <x-front.head-sub />
    </x-slot:head>

    <main id="mainContent">
        <ol class="bread-list">
            <li><a href="/">Home</a></li>
            <li><a href="#none">린나이 소식</a></li>
            <li>언론보도</li>
        </ol>
        <article id="news">
            <h1 class="bar-gray">언론보도</h1>
            <section class="information">
                <h2 class="border-red">공식 보도자료</h2>
                <p class="lead col_bot_txt_a">
                    린나이코리아의 신제품 출시부터 사회공헌 등 주요 소식을 언론 보도와 공식 보도자료로 확인하실 수 있습니다.
                </p>
                <div class="padding30"></div>
                <ul class="l-row news -pic">
                    @foreach($posts as $post)
                    <li class="l-col-4 l-col-tb-6 l-col-sm-12">
                        <a href="/board/{{ $post->board->slug }}/{{ $post->id }}"   >
                            <figure class="rn_th_img"><img src="{{ $post->thumbnail }}" alt="언론보도 썸네일"></figure>
                            <p><span class="cmn-icon icon-arrow -r"></span><time datetime="Year-Month-Date">{{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $post->created_at)->format("y.m.d") }}</time></p>
                            <p class="title col_bot_txt_b">{{ $post->title }}</p>
                        </a>
                    </li>
                    @endforeach
                </ul>
                {{ $posts->links("front.board.pagination") }}
            </section>
            <div class="padding40"></div>
        </article>

    </main>
</x-front.layout>
