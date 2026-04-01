<x-admin.layout>
    <x-slot name="header">
        사이트 설정
    </x-slot>

    <div class="max-w-4xl" x-data="settingsManager()" x-init="fetchSettings()">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="font-semibold text-gray-800 text-lg">기본 정보 관리</h3>
                <p class="text-sm text-gray-500 mt-1">사이트 전반에 노출되는 기본 정보를 설정합니다.</p>
            </div>

            <div class="p-6">
                <form class="space-y-8" @submit.prevent="saveSettings">

                    <!-- Site Name -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">사이트 이름</label>
                            <div class="text-sm text-gray-500 mt-1">브라우저 타이틀에 노출되는 이름입니다.</div>
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" x-model="settings.site_name" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="Rinnai Web">
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Footer Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">하단 정보 (Footer)</label>
                            <div class="text-sm text-gray-500 mt-1">사업자 등록번호, 주소, 전화번호 등 하단에 노출될 정보입니다.</div>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">회사명 / 대표자</label>
                                <div class="flex space-x-2">
                                    <input type="text" x-model="settings.company_name" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="회사명">
                                    <input type="text" x-model="settings.representative" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="대표자명">
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">사업자등록번호</label>
                                <input type="text" x-model="settings.business_number" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="000-00-00000">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">주소</label>
                                <input type="text" x-model="settings.address" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="서울시 중구 세종대로 ...">
                            </div>
                            {{--<div>
                                <label class="block text-xs text-gray-500 mb-1">고객센터 연락처</label>
                                <input type="text" x-model="settings.customer_center" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="1588-xxxx">
                            </div>--}}
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">카피라이트</label>
                                <input type="text" x-model="settings.copyright" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="© 2026 Rinnai. All rights reserved.">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- SEO Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">검색엔진 최적화 (SEO)</label>
                            <div class="text-sm text-gray-500 mt-1">포털사이트 검색 결과나 SNS 공유 시 노출될 메타 정보를 설정합니다.</div>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">검색엔진 노출 타이틀 (기본 사이트 이름과 다를 경우)</label>
                                <input type="text" x-model="settings.seo_title" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="린나이 코리아 - 대표 브랜드">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">사이트 설명 (Description)</label>
                                <textarea x-model="settings.seo_description" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="사이트에 대한 간략한 설명을 입력하세요."></textarea>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">검색 키워드 (Keywords, 콤마로 구분)</label>
                                <input type="text" x-model="settings.seo_keywords" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="보일러, 린나이, 가스레인지">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">SNS 공유용 미리보기 이미지 (OG Image)</label>
                                <div class="flex items-center space-x-6 mt-1">
                                    <div class="h-20 w-32 bg-gray-50 border border-gray-300 rounded-lg flex items-center justify-center overflow-hidden shrink-0">
                                        <template x-if="settings.seo_og_image">
                                            <img :src="settings.seo_og_image" class="object-cover h-full w-full" alt="OG Image">
                                        </template>
                                        <template x-if="!settings.seo_og_image">
                                            <span class="text-gray-400 text-xs">업로드 안됨</span>
                                        </template>
                                    </div>
                                    <div class="relative overflow-hidden cursor-pointer">
                                        <button type="button" class="px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            이미지 등록...
                                        </button>
                                        <input type="file" title="OG 이미지 변경" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="uploadOgImage($event)" accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- Main Video -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">메인 동영상 (YouTube)</label>
                            <div class="text-sm text-gray-500 mt-1">메인 페이지 중앙에 노출되는 홍보 영상의 유튜브 링크를 설정합니다.</div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs text-gray-500 mb-1">YouTube 영상 공유 링크 또는 아이디 (예: https://youtu.be/xxx)</label>
                            <input type="text" x-model="settings.main_youtube_url" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                    </div>

                    {{--<hr class="border-gray-100">--}}

{{--                    <!-- Maintenance Mode -->--}}
{{--                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">--}}
{{--                        <div class="md:col-span-1">--}}
{{--                            <label class="block text-sm font-medium text-gray-900">점검 모드</label>--}}
{{--                            <div class="text-sm text-gray-500 mt-1">활성화 시 관리자를 제외한 사용자에게 점검 안내 화면을 노출합니다.</div>--}}
{{--                        </div>--}}
{{--                        <div class="md:col-span-2 flex items-center h-full">--}}
{{--                            <label class="relative inline-flex items-center cursor-pointer">--}}
{{--                                <input type="checkbox" x-model="settings.maintenance_mode" class="sr-only peer">--}}
{{--                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>--}}
{{--                                <span class="ml-3 text-sm font-medium text-gray-900">점검 모드 활성화</span>--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="pt-6 border-t border-gray-100 flex justify-end">
                        <button type="button" @click="fetchSettings" class="bg-white px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 mr-3">초기화</button>
                        <button type="submit" class="bg-blue-600 px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors" :class="{ 'opacity-75 cursor-wait': saving }" :disabled="saving">저장하기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('settingsManager', () => ({
                settings: {
                    site_name: '',
                    company_name: '',
                    representative: '',
                    business_number: '',
                    //customer_center: '',
                    address: '',
                    copyright: '',
                    seo_title: '',
                    seo_description: '',
                    seo_keywords: '',
                    seo_og_image: '',
                    main_youtube_url: '',
                },
                saving: false,

                fetchSettings() {
                    axios.post('/api/admin/settings/get', {}, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        const data = response.data.data;
                        if(data) {
                            Object.keys(this.settings).forEach(key => {
                                if(data[key] !== undefined) {
                                    this.settings[key] = data[key];
                                }
                            });
                        }
                    }).catch(error => {
                        console.error(error);
                        alert('설정을 불러오는데 실패했습니다.');
                    });
                },

                saveSettings() {
                    this.saving = true;
                    // Prepare settings to be sent, parsing arrays if needed (axios handles formatting)
                    axios.post('/api/admin/settings/save', this.settings, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        alert('설정이 저장되었습니다.');
                    }).catch(error => {
                        console.error(error);
                        alert('설정 저장에 실패했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                },

                uploadOgImage(event) {
                    const file = event.target.files[0];
                    if(!file) return;

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('folder', 'logo');
                    event.target.value = ''; // Reset input

                    axios.post('/api/admin/upload', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(response => {
                        if(response.data.success) {
                            this.settings.seo_og_image = response.data.url;
                        } else {
                            alert(response.data.message || '업로드에 실패했습니다.');
                        }
                    }).catch(error => {
                        console.error(error);
                        alert('이미지 업로드 중 오류가 발생했습니다.');
                    });
                },
            }));
        });
    </script>
</x-admin.layout>
