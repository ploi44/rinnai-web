<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/assets/career/css/common.css?v=043">
    <link rel="stylesheet" type="text/css" href="/assets/career/css/swiper-bundle.min.css?v=043">
    <script src="/assets/career/js/jquery-latest.js"></script>
    <script src="/assets/career/js/swiper.min.js"></script>
    <script src="/assets/career/js/swiper-bundle.min.js?v=043"></script>
    <title>Rinnai career</title>
</head>
<body>
<div class="r_career_section">
    <div class="top_title">린나이 채용 안내</div>
    <div class="top_cr_tab">
        <div class="tab_area">
            <ul>
                <li{{ request()->is('career/career*') ? ' class=on' : '' }}><a href="{{ route("front.career.career") }}">인사제도</a></li>
                <li{{ request()->is('career/introduce*') ? ' class=on' : '' }}><a href="{{ route("front.career.introduce") }}">직무소개</a></li>
                <li{{ request()->is('career/interview*') ? ' class=on' : '' }}><a href="{{ route("front.career.interview") }}">직무 인터뷰</a></li>
            </ul>
        </div>
    </div>
    <div class="r_career_page">
        {{ $slot }}
    </div>
@if(request()->routeIs("front.career.introduce"))
    <div class="cr_sub_top_bar">
        <div class="bar_menu mNametab-1 current">
            <ul>
                <li onclick="fnMove('t1_1')">대리점 영업관리</li>
                <li onclick="fnMove('t1_2')">서비스 관리</li>
                <li onclick="fnMove('t1_3')">온라인 영업</li>
                <li onclick="fnMove('t1_4')">특판 영업</li>
                <li onclick="fnMove('t1_5')">시스템 영업</li>
            </ul>
        </div>
        <div class="bar_menu mNametab-2">
            <ul>
                <li onclick="fnMove('t2_1')">생산관리</li>
                <li onclick="fnMove('t2_2')">물류관리</li>
                <li onclick="fnMove('t2_3')">노무관리</li>
                <li onclick="fnMove('t2_4')">환경/안전관리</li>
                <li onclick="fnMove('t2_5')">제품기술</li>
                <li onclick="fnMove('t2_6')">구매</li>
                <li onclick="fnMove('t2_7')">생산기술</li>
                <li onclick="fnMove('t2_8')">금형 설계</li>
                <li onclick="fnMove('t2_9')">품질경영</li>
                <li onclick="fnMove('t2_10')">품질보증 - 제품 인증 및 평가</li>
            </ul>
        </div>
        <div class="bar_menu mNametab-3">
            <ul>
                <li onclick="fnMove('t3_1')">IP(Intellectual Property)</li>
                <li onclick="fnMove('t3_2')">기구설계</li>
                <li onclick="fnMove('t3_3')">연구개발-연소/요소기술</li>
                <li onclick="fnMove('t3_4')">S/W설계(MCU S/W)</li>
                <li onclick="fnMove('t3_5')">IoT 시스템 개발</li>
                <li onclick="fnMove('t3_6')">전자회로 설계(H/W)</li>
                <li onclick="fnMove('t3_7')">전자제어설계</li>
            </ul>
        </div>
        <div class="bar_menu mNametab-4">
            <ul>
                <li onclick="fnMove('t4_1')">경영기획</li>
                <li onclick="fnMove('t4_2')">인사</li>
                <li onclick="fnMove('t4_3')">총무</li>
                <li onclick="fnMove('t4_4')">법무</li>
                <li onclick="fnMove('t4_5')">재경</li>
                <li onclick="fnMove('t4_6')">정보기술 (Information Technology)</li>
                <li onclick="fnMove('t4_7')">상품기획</li>
                <li onclick="fnMove('t4_8')">디자인(제품)</li>
                <li onclick="fnMove('t4_9')">언론홍보</li>
                <li onclick="fnMove('t4_10')">광고</li>
                <li onclick="fnMove('t4_11')">디자인(광고/홍보)</li>
                <li onclick="fnMove('t4_12')">해외사업</li>
            </ul>
        </div>
    </div>
@endif
@if(request()->routeIs("front.career.interview"))
    <div class="cr_sub_top_bar">
        <div class="bar_menu mNametab-1 current">
            <ul>
                <li onclick="fnMove('1')">영업</li>
                <li onclick="fnMove('2')">생산/품질</li>
                <li onclick="fnMove('3')">R&amp;D</li>
                <li onclick="fnMove('4')">경영지원</li>
            </ul>
        </div>
    </div>
@endif
@if(request()->routeIs('front.career.interview.detail'))
    <!-- swiper -->
    <div class="m_mem_banner">
        <div class="m_itv_area">
            <div class="info_tt">더 많은 <br>이야기를 만나보세요</div>
            <div class="swipe_section">
                <!-- Swiper -->
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <!---->
                        @php
                            $slug = request()->route('slug');
                            $interviewMembers = [
                                ["team" => "영업 - 서울지점", "name" => "이상협 책임"],       // m1
                                ["team" => "영업 - 영업2팀", "name" => "천민우 책임"],         // m2
                                ["team" => "생산/품질 - 금형기술팀", "name" => "송재선 책임"], // m3
                                ["team" => "생산/품질 - 생산관리팀", "name" => "박진완 책임"], // m4
                                ["team" => "생산/품질 - 생산기술팀", "name" => "박주상 책임"], // m5
                                ["team" => "생산/품질 - 제품기술팀", "name" => "남정각 선임"], // m6
                                ["team" => "생산/품질 - ESL지원부", "name" => "유영훈 책임"],  // m7
                                ["team" => "생산/품질 - 품질보증팀", "name" => "이승현 책임"], // m8
                                ["team" => "생산/품질 - 품질경영팀", "name" => "이승규 책임"], // m9
                                ["team" => "R&D - 업용개발팀", "name" => "문재윤 책임"],       // m10
                                ["team" => "R&D - H/W 제어팀", "name" => "송재호 책임"],       // m11
                                ["team" => "R&D - H/W 제어팀", "name" => "김창현 책임"],       // m12
                                ["team" => "R&D - S/W 시스템팀", "name" => "장수일 책임"],     // m13
                                ["team" => "경영지원 - 경영기획부", "name" => "오승룡 수석"],  // m14
                                ["team" => "경영지원 - 인사총무부", "name" => "구자민 책임"],  // m15
                                ["team" => "경영지원 - 인사총무부", "name" => "이가영 사원"],  // m16
                                ["team" => "경영지원 - 재경부", "name" => "허은경 책임"],      // m17
                                ["team" => "경영지원 - 디자인팀", "name" => "이정국 책임"],    // m18
                                ["team" => "경영지원 - 상품기획팀", "name" => "김슬아 책임"],    // m18
                                ["team" => "경영지원 - 정보System부", "name" => "김응규 수석"] // m20
                            ];
                        @endphp
                        @for($i = 0; $i < 20; $i++)
                            @if($slug !== "m".(intval($i) +1))
                                <div class="swiper-slide">
                                    <a href="{{ route("front.career.interview.detail", "m".(intval($i) +1)) }}">
                                        <div class="m_st_box">
                                            <div class="m_b_img">
                                                <div class="img_area">
                                                    <img src="/assets/career/images/img_rinnai_mem_{{ intval($i) +1 }}.png?v=002" alt="직원사진" >
                                                </div>
                                            </div>
                                            <div class="m_b_text">
                                                <div class="mb_team">{{ $interviewMembers[$i]["team"] }}</div>
                                                <div class="mb_name">{{ $interviewMembers[$i]["name"] }}</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endfor
                    </div>
                    <!-- Add Arrows -->
                    <div class="swiper-button-next"><img src="/assets/career/images/img_sw_right.png?v=002?v=112" /></div>
                    <div class="swiper-button-prev"><img src="/assets/career/images/img_sw_left.png?v=002?v=112" /></div>
                </div>
                <!-- Swiper -->
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var swiper = new Swiper(".mySwiper", {
                slidesPerView: 3,
                spaceBetween: 30,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });
    </script>
@endif
</div>
</body>
</html>
