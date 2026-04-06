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
            <h1 class="bar-gray">{{ $post->board->name }}</h1>
            <section class="information">
                <h2 class="border-red">{{ $post->title }}</h2>
                <p class="lead col_bot_txt">
                    {{ \Carbon\Carbon::createFromFormat("Y-m-d H:i:s", $post->created_at)->format("Y-m-d") }}
                </p>
                <div class="padding30"></div>
                <div class="view_page_section">
                    <!--view section-->
                    {!! $post->content !!}
                    <!--view section-->
                </div>
                <p class="list_go_area">
                    <a class="border-btn" href="/board/{{ $post->board->slug }}"><span class="cmn-icon icon-arrow -r"></span>목록보기</a>
                </p>
            </section>
            <div class="padding40"></div>
        </article>

    </main>
</x-front.layout>
