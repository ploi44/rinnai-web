<x-front.layout>
    <x-slot:head>
        <x-front.head-sub />
    </x-slot:head>

    <main id="mainContent">
        <ol class="bread-list">
            <li><a href="/">Home</a></li>
            <li><a href="#none">린나이 코리아 소개</a></li>
            <li>린나이코리아 연혁</li>
        </ol>
        <article id="brand">
            <section class="sec01">
                <h1 class="bar-gray">린나이 코리아 연혁</h1>
                <h2 class="border-red">연혁</h2>
                <div class="inner">
                    <p class="lead col_bot_txt_a">
                        린나이코리아는 반세기 넘는 시간 동안 고객의 일상과 함께하며 신뢰를 쌓아왔습니다. <br>
                        지난 50여 년의 경험과 기술을 바탕으로 더 나은 생활 가치를 제안하고, 앞으로도 변함없는 품질과 서비스로 고객 곁에서 지속 가능한 성장을 이어가겠습니다.
                    </p>
                    <div class="padding30"></div>
                    <table>
                        <colgroup>
                            <col width="30%"/>
                            <col width="*%"/>
                        </colgroup>
                        <tbody>
                        @foreach($histories as $history)
                        <tr>
                            <th>{{ $history->year }}</th>
                            <td>{{ $history->content }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="padding40"></div>
                </div>
            </section>
            <div class="padding40"></div>
        </article>

    </main>
</x-front.layout>
