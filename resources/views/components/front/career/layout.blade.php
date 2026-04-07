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
</div>
</body>
</html>
