<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class YoutubeController extends Controller
{
    public function fetch(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'board_id' => 'required|integer',
        ]);

        $url = $request->input('url');
        $boardId = $request->input('board_id');

        try {
            // 1. oEmbed 데이터 가져오기
            $oembedUrl = 'https://www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';
            $response = Http::timeout(10)->get($oembedUrl);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => '유튜브 영상 정보를 가져올 수 없습니다. 유효한 주소인지 확인해주세요.'
                ], 400);
            }

            $data = $response->json();
            $title = $data['title'] ?? '';
            $thumbnailUrl = $data['thumbnail_url'] ?? '';
            $description = '';

            // 2. 썸네일 이미지 서버에 다운로드 후 저장
            $localThumbnailUrl = null;
            if ($thumbnailUrl) {
                if (preg_match('/vi\/([a-zA-Z0-9_-]{11})/', $thumbnailUrl, $matches)) {
                    $videoId = $matches[1];
                    $thumbnailUrl = "https://i.ytimg.com/vi/{$videoId}/maxresdefault.jpg";
                }
                $imageResponse = Http::timeout(15)->get($thumbnailUrl);
                if ($imageResponse->successful()) {
                    $imageContent = $imageResponse->body();
                    $extension = pathinfo(parse_url($thumbnailUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                    if (!$extension) {
                        $extension = 'jpg'; // 기본 확장자
                    }
                    $filename = Str::uuid() . '.' . $extension;

                    // UploadController와 동일한 규칙 적용
                    $subPath = 'uploads/board/' . $boardId . '/' . $filename;

                    Storage::disk('public')->put($subPath, $imageContent);
                    $localThumbnailUrl = '/storage/' . $subPath;
                }
            }

            // 3. 태그 추출 시도 (HTML 메타데이터 scraping)
            $tags = [];
            try {
                $htmlResponse = Http::timeout(10)->get($url);
                if ($htmlResponse->successful()) {
                    $html = $htmlResponse->body();
                    // <meta name="keywords" content="..."> 추출 시도
                    if (preg_match('/<meta[^>]*name=["\']keywords["\'][^>]*content=["\']([^"\']+)["\']/i', $html, $matches) ||
                        preg_match('/<meta[^>]*content=["\']([^"\']+)["\'][^>]*name=["\']keywords["\']/i', $html, $matches)) {
                        $content_str = $matches[1];
                        $tagsTemp = array_map('trim', explode(',', $content_str));
                        // 불필요한 공용 키워드 필터링 등 방어 로직 (선택적)
                        $tags = array_filter($tagsTemp);
                    }

                    // <meta name="description" content="..."> 추출 시도
                    if (preg_match('/<meta[^>]*name=["\']description["\'][^>]*content=["\']([^"\']+)["\']/i', $html, $descMatches) ||
                        preg_match('/<meta[^>]*content=["\']([^"\']+)["\'][^>]*name=["\']description["\']/i', $html, $descMatches)) {
                        $description = $descMatches[1];
                    }
                }
            } catch (\Exception $e) {
                // HTML 태그 추출 실패 시 oembed의 author_name으로 대체 또는 무시
            }

            // 태그가 여전히 비어있다면 oEmbed author_name 이라도 사용
            if (empty($tags) && isset($data['author_name'])) {
                $tags[] = $data['author_name'];
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'title' => $title,
                    'thumbnail' => $localThumbnailUrl,
                    'tags' => implode(', ', $tags),
                    'content' => !empty($description) ? html_entity_decode($description, ENT_QUOTES) : $title
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '유튜브 정보 처리 중 오류가 발생했습니다: ' . $e->getMessage()
            ], 500);
        }
    }
}
