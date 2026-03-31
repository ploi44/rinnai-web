<x-admin.layout>
    <x-slot name="header">
        새 게시판 생성
    </x-slot>

    <div class="max-w-4xl" x-data="boardCreator()">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800 text-lg">게시판 기본 설정</h3>
                    <p class="text-sm text-gray-500 mt-1">게시판의 이름과 유형을 결정합니다. 유형은 생성 후 변경할 수 없습니다.</p>
                </div>
            </div>

            <div class="p-6">
                <form @submit.prevent="createBoard" class="space-y-8">

                    <!-- Board ID -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-50 pb-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">게시판 ID (Slug)</label>
                            <div class="text-sm text-gray-500 mt-1">URL에 표시되는 영문 식별자입니다. 띄어쓰기 없이 단어만 가능합니다.</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex rounded-md shadow-sm">
                                <span class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 px-3 text-gray-500 sm:text-sm bg-gray-50">/boards/</span>
                                <input type="text" x-model="form.slug" class="block w-full min-w-0 flex-1 rounded-none rounded-r-md border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" placeholder="ex) notice" required>
                            </div>
                        </div>
                    </div>

                    <!-- Board Name -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-b border-gray-50 pb-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">게시판 이름</label>
                            <div class="text-sm text-gray-500 mt-1">사용자에게 보여질 게시판의 한글 이름입니다.</div>
                        </div>
                        <div class="md:col-span-2">
                            <input type="text" x-model="form.name" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm py-2 px-3" placeholder="ex) 공지사항" required>
                        </div>
                    </div>

                    <!-- Board Type Select -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-900">게시판 유형 선택</label>
                            <div class="text-sm text-rose-500 mt-1 font-medium">※ 중요: 최초 생성 이후에는 유형을 전환할 수 없습니다.</div>
                        </div>
                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                                <!-- Type: General -->
                                <div>
                                    <input type="radio" name="board_type" id="type_general" value="general" x-model="form.type" class="peer sr-only">
                                    <label for="type_general" class="block cursor-pointer rounded-xl border border-gray-200 bg-white p-4 hover:bg-gray-50 peer-checked:border-blue-600 peer-checked:ring-1 peer-checked:ring-blue-600 transition-all flex flex-col h-full relative">
                                        <div class="absolute top-4 right-4 text-blue-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900 text-sm mb-1">일반 게시판</h4>
                                        <p class="text-xs text-gray-500 flex-1">텍스트 위주의 리스트 형태 게시판 (공지사항, 자유게시판 등)</p>
                                    </label>
                                </div>

                                <!-- Type: Gallery -->
                                <div>
                                    <input type="radio" name="board_type" id="type_gallery" value="album" x-model="form.type" class="peer sr-only">
                                    <label for="type_gallery" class="block cursor-pointer rounded-xl border border-gray-200 bg-white p-4 hover:bg-gray-50 peer-checked:border-purple-600 peer-checked:ring-1 peer-checked:ring-purple-600 transition-all flex flex-col h-full relative">
                                        <!-- Checked Icon -->
                                        <div class="absolute top-4 right-4 text-purple-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-600 mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900 text-sm mb-1">앨범 / 갤러리</h4>
                                        <p class="text-xs text-gray-500 flex-1">이미지 썸네일 중심의 그리드 형태 게시판 (사진첩 등)</p>
                                    </label>
                                </div>

                                <!-- Type: Youtube -->
                                <div>
                                    <input type="radio" name="board_type" id="type_youtube" value="youtube" x-model="form.type" class="peer sr-only">
                                    <label for="type_youtube" class="block cursor-pointer rounded-xl border border-gray-200 bg-white p-4 hover:bg-gray-50 peer-checked:border-red-600 peer-checked:ring-1 peer-checked:ring-red-600 transition-all flex flex-col h-full relative">
                                        <!-- Checked Icon -->
                                        <div class="absolute top-4 right-4 text-red-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-600 mb-3">
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900 text-sm mb-1">유튜브형 게시판</h4>
                                        <p class="text-xs text-gray-500 flex-1">유튜브 영상 링크를 썸네일과 함께 연동하는 게시판</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ route('admin.boards.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                            취소
                        </a>
                        <button type="submit" :disabled="saving" class="bg-blue-600 px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors inline-flex items-center disabled:opacity-50">
                            <span x-show="!saving" class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                게시판 생성 완료하기
                            </span>
                            <span x-show="saving">처리중...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('boardCreator', () => ({
                form: {
                    slug: '',
                    name: '',
                    type: 'general'
                },
                saving: false,

                createBoard() {
                    this.saving = true;
                    axios.post('/api/admin/boards/store', this.form, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        alert('게시판이 생성되었습니다.');
                        window.location.href = "{{ route('admin.boards.index') }}";
                    }).catch(error => {
                        console.error(error);
                        if (error.response && error.response.data && error.response.data.message) {
                            alert('오류: ' + error.response.data.message);
                        } else {
                            alert('게시판 생성에 실패했습니다.');
                        }
                    }).finally(() => {
                        this.saving = false;
                    });
                }
            }));
        });
    </script>
</x-admin.layout>
