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

                    <!-- Logo -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">로고 이미지</label>
                            <div class="text-sm text-gray-500 mt-1">상단 헤더에 들어갈 로고 이미지를 등록합니다. 권장 사이즈 200x50px.</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center space-x-6">
                                <div class="h-16 w-32 bg-white border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden shrink-0">
                                    <template x-if="settings.site_logo">
                                        <img :src="settings.site_logo" class="object-contain h-full w-full p-1" alt="사이트 로고">
                                    </template>
                                    <template x-if="!settings.site_logo">
                                        <span class="text-gray-400 text-sm">로고 없음</span>
                                    </template>
                                </div>
                                <div class="relative overflow-hidden cursor-pointer">
                                    <button type="button" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        변경...
                                    </button>
                                    <input type="file" title="로고 변경" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="uploadSiteLogo($event)" accept="image/*">
                                </div>
                            </div>
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
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">고객센터 연락처</label>
                                <input type="text" x-model="settings.customer_center" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="1588-xxxx">
                            </div>
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

                    <hr class="border-gray-100">

                    <!-- Maintenance Mode -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">점검 모드</label>
                            <div class="text-sm text-gray-500 mt-1">활성화 시 관리자를 제외한 사용자에게 점검 안내 화면을 노출합니다.</div>
                        </div>
                        <div class="md:col-span-2 flex items-center h-full">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="settings.maintenance_mode" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                <span class="ml-3 text-sm font-medium text-gray-900">점검 모드 활성화</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-gray-100">

                    <!-- SNS Links -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">SNS 링크 설정</label>
                            <div class="text-sm text-gray-500 mt-1">푸터 등에 표시될 SNS 아이콘 링크를 관리합니다.</div>
                            <button type="button" @click="addSnsLink()" class="mt-4 px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                + 링크 추가
                            </button>
                        </div>
                        <div class="md:col-span-2 space-y-4">
                            <template x-if="settings.sns_links.length === 0">
                                <div class="text-sm text-gray-500 py-4 text-center border-2 border-dashed border-gray-200 rounded-lg">등록된 SNS 링크가 없습니다.</div>
                            </template>

                            <template x-for="(link, index) in settings.sns_links" :key="index">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 relative mb-4">
                                    <button type="button" @click="removeSnsLink(index)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 focus:outline-none" title="삭제">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mr-8">
                                        <!-- Service Name -->
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">서비스명 (예: Instagram)</label>
                                            <input type="text" x-model="link.name" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="서비스명">
                                        </div>
                                        <!-- Link URL -->
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">링크 주소</label>
                                            <input type="text" x-model="link.url" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="https://...">
                                        </div>
                                        <!-- Display Order & Status -->
                                        <div class="flex space-x-4">
                                            <div class="flex-1">
                                                <label class="block text-xs text-gray-500 mb-1">노출 순서</label>
                                                <input type="number" x-model.number="link.sort_order" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="0">
                                            </div>
                                            <div class="flex-1">
                                                <label class="block text-xs text-gray-500 mb-1">사용여부</label>
                                                <select x-model="link.is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3">
                                                    <option :value="true">사용함</option>
                                                    <option :value="false">사용안함</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Logo Image Upload -->
                                        <div>
                                            <label class="block text-xs text-gray-500 mb-1">로고 이미지</label>
                                            <div class="flex items-center space-x-3">
                                                <div class="h-10 w-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center overflow-hidden shrink-0">
                                                    <template x-if="link.logo">
                                                        <img :src="link.logo" class="object-cover h-full w-full" alt="로고">
                                                    </template>
                                                    <template x-if="!link.logo">
                                                        <span class="text-xs text-gray-300">없음</span>
                                                    </template>
                                                </div>
                                                <div class="relative overflow-hidden cursor-pointer w-full">
                                                    <button type="button" class="w-full px-3 py-2 border border-gray-300 shadow-sm text-xs font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                                        파일 선택
                                                    </button>
                                                    <input type="file" title="로고 선택" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" @change="uploadLogo($event, index)" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

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
                    site_logo: '',
                    company_name: '',
                    representative: '',
                    business_number: '',
                    customer_center: '',
                    address: '',
                    copyright: '',
                    maintenance_mode: false,
                    sns_links: [],
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
                                    if(key === 'maintenance_mode') {
                                        this.settings[key] = data[key] === 'true' || data[key] === '1';
                                    } else if (key === 'sns_links') {
                                        try {
                                            this.settings[key] = typeof data[key] === 'string' ? JSON.parse(data[key]) : data[key] || [];
                                        } catch(e) {
                                            this.settings[key] = [];
                                        }
                                    } else {
                                        this.settings[key] = data[key];
                                    }
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

                addSnsLink() {
                    this.settings.sns_links.push({ name: '', url: '', logo: '', sort_order: this.settings.sns_links.length, is_active: true });
                },

                removeSnsLink(index) {
                    this.settings.sns_links.splice(index, 1);
                },

                uploadSiteLogo(event) {
                    const file = event.target.files[0];
                    if(!file) return;

                    const formData = new FormData();
                    formData.append('file', file);
                    event.target.value = ''; // Reset input

                    axios.post('/api/admin/upload', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(response => {
                        if(response.data.success) {
                            this.settings.site_logo = response.data.url;
                        } else {
                            alert(response.data.message || '업로드에 실패했습니다.');
                        }
                    }).catch(error => {
                        console.error(error);
                        alert('이미지 업로드 중 오류가 발생했습니다.');
                    });
                },

                uploadOgImage(event) {
                    const file = event.target.files[0];
                    if(!file) return;

                    const formData = new FormData();
                    formData.append('file', file);
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

                uploadLogo(event, index) {
                    const file = event.target.files[0];
                    if(!file) return;

                    const formData = new FormData();
                    formData.append('file', file);
                    event.target.value = ''; // Reset input

                    axios.post('/api/admin/upload', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(response => {
                        if(response.data.success) {
                            this.settings.sns_links[index].logo = response.data.url;
                        } else {
                            alert(response.data.message || '업로드에 실패했습니다.');
                        }
                    }).catch(error => {
                        console.error(error);
                        alert('이미지 업로드 중 오류가 발생했습니다.');
                    });
                }
            }));
        });
    </script>
</x-admin.layout>
