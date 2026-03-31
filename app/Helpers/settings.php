<?php

if (!function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        $settings = \Illuminate\Support\Facades\Cache::rememberForever('global_site_settings', function () {
            try {
                return \App\Models\Setting::pluck('value', 'key')->all();
            } catch (\Exception $e) {
                return [];
            }
        });

        return array_key_exists($key, $settings) ? $settings[$key] : $default;
    }
}
// ?autoplay=1&mute=1&rel=0&loop=1&playlist=pJZT1VeT5S8
if(!function_exists('getMainYoutubePlayerHtml')){
    function getMainYoutubeEmbedUrl() {
        $defaults = [
            "autoplay" => 1,
            "mute" => 1,
            "rel" => 0,
            "loop" => 1,
        ];
        $youtubeUrl = setting("main_youtube_url");
        $embedUrl = "";
        // 유튜브 다양한 URL 패턴 (watch, youtu.be, shorts, embed 등)
        $pattern = '/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=|shorts\/)([^#&?]*).*/';

        if (preg_match($pattern, $youtubeUrl, $matches)) {
            $videoId = $matches[2];

            // ID 길이가 11자인지 확인 (유튜브 표준 ID 길이)
            if (strlen($videoId) === 11) {
                $queryString = parse_url($youtubeUrl, PHP_URL_QUERY);
                $userParams = [];
                if ($queryString) {
                    parse_str($queryString, $userParams);
                } else {
                    $defaults["playlist"] = $videoId;
                }
                $finalParams = array_merge($userParams, $defaults);
                $query = http_build_query($finalParams);
                $embedUrl = "https://www.youtube.com/embed/{$videoId}". ($query ? '?' . $query : '');
            }
        }

        return $embedUrl; // 올바르지 않은 주소일 경우
    }
}
