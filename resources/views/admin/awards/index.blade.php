<x-admin.layout>
    <x-slot name="header">
        수상내역 관리
    </x-slot>

    <!-- Page Alert -->
    <div class="mb-6 rounded-xl bg-blue-50 p-4 border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">사이트에 노출되는 수상내역들을 관리합니다. 수상명, 이미지, 노출 순서 등을 설정할 수 있습니다.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="awardsManager()" x-init="fetchAwards()">
        <!-- Toolbar -->
        <div class="flex justify-between items-center p-6 border-b border-gray-100">
            <div class="flex items-center w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" x-model="search" @keydown.enter="page=1; fetchAwards()" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="수상명 검색...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button @click="page=1; fetchAwards()" class="ml-3 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    검색
                </button>
            </div>
            <button @click="openModal()" class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                새 수상내역 등록
            </button>
        </div>

        <!-- Award List -->
        <div class="p-6">
            <template x-if="awards.length === 0">
                <div class="py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 rounded-xl">
                    <p>등록된 수상내역이 없습니다.</p>
                </div>
            </template>

            <div class="space-y-4" x-ref="sortableList">
                <template x-for="award in awards" :key="award.id">
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl p-4 transition-shadow hover:shadow-md" :data-id="award.id">
                        <div class="handle cursor-grab active:cursor-grabbing p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </div>
                        <div class="w-32 h-24 bg-gray-200 rounded-lg overflow-hidden shrink-0 relative flex items-center justify-center ml-2">
                            <template x-if="award.image_path">
                                <img :src="award.image_path" class="w-full h-full object-cover" alt="Award Image">
                            </template>
                            <template x-if="!award.image_path">
                                <span class="text-xs text-gray-400">이미지 없음</span>
                            </template>
                        </div>
                        <div class="ml-6 flex-1">
                            <h4 class="text-base font-bold text-gray-900" x-text="award.title"></h4>
                            <div class="mt-2 flex space-x-3 text-sm text-gray-600">
                                <span>노출 순서: <span x-text="award.order" class="font-bold"></span></span>
                                <span :class="award.is_active ? 'text-green-600 font-bold' : 'text-rose-500'">상태: <span x-text="award.is_active ? '노출중' : '숨김'"></span></span>
                            </div>
                        </div>
                        <div class="ml-6 flex flex-col space-y-2 shrink-0">
                            <button @click="openModal(award)" class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors border border-blue-200">수정</button>
                            <button @click="deleteAward(award.id)" class="px-3 py-1.5 text-sm font-medium text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors border border-rose-200">삭제</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between" x-show="total > 0">
            <div class="text-sm text-gray-500">
                총 <span class="font-medium text-gray-900" x-text="total"></span>개 중 페이지 <span class="font-medium text-gray-900" x-text="page"></span>/<span class="font-medium text-gray-900" x-text="lastPage"></span>
            </div>
            <div class="flex space-x-1">
                <button @click="if(page > 1) { page--; fetchAwards(); }" :disabled="page <= 1" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">이전</button>
                <button @click="if(page < lastPage) { page++; fetchAwards(); }" :disabled="page >= lastPage" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">다음</button>
            </div>
        </div>

        <!-- Modal for Create/Edit -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isModalOpen" x-transition.duration.300ms class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                        <h3 class="text-lg leading-6 font-semibold text-gray-900" id="modal-title" x-text="form.id ? '수상내역 수정' : '새 수상내역 등록'"></h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6 space-y-5">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">수상명 <span class="text-rose-500">*</span></label>
                            <input type="text" x-model="form.title" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="예: 2026 브랜드 파워 1위">
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">이미지 썸네일</label>
                            <div class="mt-2 flex items-center">
                                <div class="h-24 w-32 border border-gray-300 rounded-md overflow-hidden bg-gray-50 flex items-center justify-center shrink-0">
                                    <img x-show="form.image_path" :src="form.image_path" class="h-full object-cover">
                                    <span x-show="!form.image_path" class="text-xs text-gray-400">없음</span>
                                </div>
                                <div class="ml-4 flex flex-col space-y-2">
                                    <div class="relative">
                                        <button type="button" class="px-3 py-1.5 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">업로드</button>
                                        <input type="file" @change="uploadImage($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                    </div>
                                    <button type="button" @click="form.image_path = null" x-show="form.image_path" class="text-xs text-rose-500 hover:text-rose-700 text-left">이미지 삭제</button>
                                </div>
                            </div>
                        </div>

                        <!-- Configuration -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">노출 순서</label>
                                <input type="number" x-model.number="form.order" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="0">
                                <p class="text-xs text-gray-500 mt-1">숫자가 낮을수록 먼저 표시됩니다.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">상태</label>
                                <select x-model="form.is_active"
                                        @change="form.is_active = ($event.target.value === 'true')"
                                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option :value="true">노출 (Active)</option>
                                    <option :value="false">숨김 (Inactive)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-xl border-t border-gray-100">
                        <button type="button" @click="saveAward()" :disabled="saving" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                            <span x-text="saving ? '처리중...' : '저장하기'"></span>
                        </button>
                        <button type="button" @click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            취소
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('awardsManager', () => ({
                awards: [],
                search: '',
                page: 1,
                lastPage: 1,
                total: 0,

                isModalOpen: false,
                saving: false,

                form: {
                    id: null,
                    title: '',
                    image_path: null,
                    order: 0,
                    is_active: true
                },

                fetchAwards() {
                    axios.post('/api/admin/awards/list', {
                        search: this.search,
                        page: this.page
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        const res = response.data.data;
                        this.awards = res.data;
                        this.page = res.current_page;
                        this.lastPage = res.last_page;
                        this.total = res.total;
                        this.$nextTick(() => { this.initSortable(); });
                    }).catch(error => {
                        console.error(error);
                        alert('수상내역 목록을 불러오는데 실패했습니다.');
                    });
                },

                initSortable() {
                    if (this.sortableInstance) {
                        this.sortableInstance.destroy();
                    }
                    if (this.$refs.sortableList) {
                        this.sortableInstance = new Sortable(this.$refs.sortableList, {
                            handle: '.handle',
                            animation: 150,
                            onEnd: (evt) => {
                                const itemEls = Array.from(this.$refs.sortableList.children).filter(el => el.hasAttribute('data-id'));
                                const newOrder = itemEls.map((el, index) => ({
                                    id: parseInt(el.getAttribute('data-id')),
                                    order: index + 1 // award controller expects `order` not `sort_order`
                                }));
                                this.saveOrder(newOrder);
                            }
                        });
                    }
                },

                saveOrder(newOrder) {
                    axios.post('/api/admin/awards/reorder', { items: newOrder }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => {
                        if(res.data.success) {
                            this.fetchAwards();
                        }
                    }).catch(err => {
                        console.error('순서 저장 오류:', err);
                        alert('순서 저장에 실패했습니다.');
                    });
                },

                openModal(award = null) {
                    if(award) {
                        this.form = { ...award };
                    } else {
                        const maxOrder = this.awards.length > 0 ? Math.max(...this.awards.map(a => a.order || 0)) + 1 : 1;
                        this.form = { id: null, title: '', image_path: null, order: maxOrder, is_active: true };
                    }
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                uploadImage(event) {
                    const file = event.target.files[0];
                    if(!file) return;

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('folder', 'award');
                    event.target.value = '';

                    axios.post('/api/admin/upload', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(response => {
                        this.form.image_path = response.data.url;
                    }).catch(err => {
                        console.error(err);
                        alert('이미지 업로드에 실패했습니다.');
                    });
                },

                saveAward() {
                    if(!this.form.title.trim()) {
                        alert('수상명을 입력해주세요.');
                        return;
                    }

                    this.saving = true;

                    const url = this.form.id ? '/api/admin/awards/update' : '/api/admin/awards/store';

                    axios.post(url, this.form, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        if(response.data.success) {
                            this.closeModal();
                            this.fetchAwards();
                        }
                    }).catch(error => {
                        console.error(error);
                        alert(error.response?.data?.message || '저장 중 오류가 발생했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                },

                deleteAward(id) {
                    if(confirm('이 수상내역을 삭제하시겠습니까?')) {
                        axios.post('/api/admin/awards/delete', { id }, {
                            headers: { 'Content-Type': 'application/json' }
                        }).then(res => {
                            this.fetchAwards();
                        }).catch(err => {
                            console.error(err);
                            alert('삭제에 실패했습니다.');
                        });
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
