<x-front.layout>
    <x-slot:head>
        <x-front.head-sub>
            <x-slot:title>Rinnai</x-slot:title>
        </x-front.head-sub>
    </x-slot:head>

    <main id="mainContent">
        <ol class="bread-list">
            <li><a href="/">Home</a></li>
            <li><a href="#none">린나이 코리아 소개</a></li>
            <li>기업정보</li>
        </ol>
        <article id="brand">
            <section class="sec01">
                <h1 class="bar-gray">기업정보</h1>
                <div class="inner">
                    <img src="../assets/images/corp/company/comp_top_vs_img.jpg" alt="기업정보 이미지">
                </div>
            </section>
            <div class="padding30"></div>
            <section class="sec02">
                <h2 class="border-red">린나이는 건강하고, 편안한 삶을 창조합니다</h2>
                <div class="inner">
                    <div class="block">
                        <p class="promise comp text_pc_view">
                            린나이가 고객과 사회에 약속하는<br> 그것이 <b>Creating a healthier way of living</b> 입니다.
                        </p>
                        <p class="promise comp text_mob_view">
                            린나이가 고객과 사회에 약속하는 그것이 <b>Creating a healthier way of living</b> 입니다.
                        </p>
                        <div class="block">
                            <ul class="l-row">
                                <li class="l-col-4 l-col-sm-12">
                                    <img src="../assets/images/corp/company/comp_img_ch_1.jpg" alt="린나이는 건강하고, 편안한 삶을 창조합니다">
                                    <div class="col_bot_txt">
                                        지속 가능한 환경과 공존하며<br>
                                        사람들의 삶을 즐겁고 풍요롭게 만드는 것
                                    </div>
                                </li>
                                <li class="l-col-4 l-col-sm-12">
                                    <img src="../assets/images/corp/company/comp_img_ch_2.jpg" alt="린나이는 건강하고, 편안한 삶을 창조합니다">
                                    <div class="col_bot_txt">
                                        고품질의 제품을 만들고 사람들의 삶을 보다 건강하고,<br>
                                        더 편안하게 만들어 주는 것
                                    </div>
                                </li>
                                <li class="l-col-4 l-col-sm-12">
                                    <img src="../assets/images/corp/company/comp_img_ch_3.jpg" alt="린나이는 건강하고, 편안한 삶을 창조합니다">
                                    <div class="col_bot_txt">
                                        품질 기준을 확고히 고수하면서도<br>
                                        기능과 디자인을 채택하고 환경까지 고려하는 것
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section class="sec03">
                <h2 class="border-red">인재상</h2>
                <div class="inner">
                    <div class="l-row mat20">
                        <div class="l-col-5 l-col-sm-12">
                            <h3 class="border-gray">창의적인 熱情人</h3>
                            <p class="col_bot_txt_a">
                                참신한 발상으로 구태에 얽매이지 않으며
                                일에 대한 애정을 가지고 자기 일에 책임을 다하는 열정인
                            </p>
                            <h3 class="border-gray">성장하는 專門人</h3>
                            <p class="col_bot_txt_a">
                                끊임없이 학습하여 자신을 성장시키고
                                목표를 달성하는 전문인
                            </p>
                            <h3 class="border-gray">화합하는 協力人</h3>
                            <p class="col_bot_txt_a">
                                팀워크와 인간관계의 중요성을 인식하고
                                더불어 일하는 협력인
                            </p>
                            <div class="padding30"></div>
                            <p>
                                <a class="text-link" href="/dummy/" target="_blank">
                                    <span class="cmn-icon icon-arrow -r"></span>린나이 채용안내
                                    <span class="cmn-icon icon-svg icon-external" aria-label="Open an external link"></span>
                                </a>
                            </p>
                        </div>
                        <div class="l-col-7 l-col-sm-12">
                            <div class="padding50"></div>
                            <figure class="tar"><img src="../assets/images/corp/company/comp_img_hm_1.jpg" alt=""></figure>
                        </div>
                    </div>
                </div>
            </section>
            <div class="padding50"></div>
            <section class="sec04">
                <h2 class="border-red">수상내역</h2>
                <div class="inner">
                    <p class="lead col_bot_txt_a">
                        권위와 공신력으로 당당히 인정받은 대한민국 1등 브랜드 - 린나이코리아<br>
                        정상은 끝이 아니라 새로운 시작, 정상을 넘어 또 다른 정상을 향한 린나이의 도전은 계속됩니다.
                    </p>
                    <div class="padding20"></div>
                    <div class="l-row">
                        @foreach($awards as $award)
                        <div class="l-col-3 l-col-sm-12">
                            <figure>
                                <img src="{{ $award->image_path }}" alt="{{ $award->title }}">
                                <div class="col_bot_txt_sm">
                                    {{ $award->title }}
                                </div>
                            </figure>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <div class="padding50"></div>
            <section class="sec05">
                <h2 class="border-red">본사 및 공장안내</h2>
                <div class="inner">
                    <div class="block">
                        <ul class="l-row">
                            <li class="l-col-4 l-col-sm-12">
                                <img src="../assets/images/corp/company/comp_img_building_1.jpg" alt="본사 및 2공장">
                                <div class="col_bot_txt">
                                    <div class="in_tit">본사 및 2공장</div>
                                    주소 : 인천광역시 부평구 백범로577번길 48 (십정동)<br>
                                    대표 전화 : 032-570-8300<br>
                                    대표 FAX : 032-578-7024
                                </div>
                            </li>
                            <li class="l-col-4 l-col-sm-12">
                                <img src="../assets/images/corp/company/comp_img_building_2.jpg" alt="가좌사무소(3공장)">
                                <div class="col_bot_txt">
                                    <div class="in_tit">가좌사무소(3공장)</div>
                                    주소 : 인천광역시 서구 가좌로 12번길 39(가좌동)<br>
                                    대표 FAX : 032-578-7024
                                </div>
                            </li>
                            <li class="l-col-4 l-col-sm-12">
                                <img src="../assets/images/corp/company/comp_img_building_3.jpg" alt="1공장">
                                <div class="col_bot_txt">
                                    <div class="in_tit">1공장</div>
                                    주소 : 인천광역시 서구 가좌로 29번길 38(가좌동)<br>
                                    대표 FAX : 032-578-7034
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="inner">
                    <h3 class="border-gray">사업부</h3>
                    <div class="inner">
                        <!-- Table -->
                        <table>
                            <colgroup>
                                <col width="30%"/>
                                <col width="*%"/>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th>서울경기지역</th>
                                <td>서울특별시 영등포구 국회대로 612(당산동3가) 코레일유통 18층</td>
                            </tr>
                            <tr>
                                <th>대전지역</th>
                                <td>대전광역시 동구 한밭대로 1307, 우성빌딩 8층(용전동)</td>
                            </tr>
                            <tr>
                                <th>대구지역</th>
                                <td>대구광역시 동구 동대구로 447 1층 (신천동)</td>
                            </tr>
                            <tr>
                                <th>광주지역</th>
                                <td>광주광역시 북구 금남로 80 송강빌딩 1층</td>
                            </tr>
                            <tr>
                                <th>부산지역</th>
                                <td>부산광역시 동구 중앙대로 538, 신성빌딩 6층 (범일동)</td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- /Table -->
                    </div>
                </div>
                <div class="inner">
                    <h3 class="border-gray">관련사 소개</h3>
                    <div class="inner">
                        <!-- Table -->
                        <table>
                            <colgroup>
                                <col width="30%"/>
                                <col width="40%"/>
                                <col width="*%"/>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th>린나이플러스(주)</th>
                                <td>서울 금천구 가산디지털1로 128 STX-V 타워 213호</td>
                                <td>02-811-3300~5</td>
                            </tr>
                            <tr>
                                <th>RB코리아(주)</th>
                                <td>인천광역시 서구 백범로603번길 4 (가좌동)</td>
                                <td>032-583-0450</td>
                            </tr>
                            <tr>
                                <th>RS코리아(주)</th>
                                <td>인천광역시 서구 가재울로 75 (가좌동)</td>
                                <td>032-584-3500~3</td>
                            </tr>
                            <tr>
                                <th>미쿠니RK</th>
                                <td>인천광역시 서구 백범로603번길 4 (가좌동)</td>
                                <td>032-578-5501~4</td>
                            </tr>
                            </tbody>
                        </table>
                        <!-- /Table -->
                    </div>
                </div>
            </section>
        </article>

    </main>
</x-front.layout>
