<x-admin.layout>
    <x-slot name="header">
        메인 슬라이드 배너 관리
    </x-slot>

    <!-- Page Alert -->
    <div class="mb-6 rounded-xl bg-blue-50 p-4 border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">사이트 메인 페이지 최상단에 노출되는 대형 비주얼 배너(PC/Mobile)를 관리합니다. 화살표를 드래그하거나 순서를 입력하여 노출 순서를 변경할 수 있습니다.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="bannersManager()" x-init="fetchBanners()">
        <!-- Toolbar -->
        <div class="flex justify-end items-center p-6 border-b border-gray-100">
            <button @click="openModal()" class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                새 배너 등록
            </button>
        </div>

        <!-- Banner List -->
        <div class="p-6">
            <template x-if="banners.length === 0">
                <div class="py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 rounded-xl">
                    <p>등록된 배너가 없습니다.</p>
                </div>
            </template>

            <div class="space-y-4" x-ref="sortableList">
                <template x-for="banner in banners" :key="banner.id">
                    <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl p-4 transition-shadow hover:shadow-md" :data-id="banner.id">
                        <div class="handle cursor-grab active:cursor-grabbing p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </div>
                        <div class="w-48 h-24 bg-gray-200 rounded-lg overflow-hidden shrink-0 relative flex items-center justify-center ml-2">
                            <template x-if="banner.pc_image">
                                <img :src="banner.pc_image" class="w-full h-full object-cover" alt="Banner Image">
                            </template>
                        </div>
                        <div class="ml-6 flex-1">
                            <div class="flex space-x-3 text-sm text-gray-700">
                                <span>순서: <span x-text="banner.sort_order" class="font-bold"></span></span>
                                <span :class="banner.is_active ? 'text-green-600 font-bold' : 'text-red-500'">상태: <span x-text="banner.is_active ? '노출중' : '숨김'"></span></span>
                            </div>
                        </div>
                        <div class="ml-6 flex flex-col space-y-2 shrink-0">
                            <button @click="openModal(banner)" class="px-3 py-1.5 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">수정</button>
                            <button @click="deleteBanner(banner.id)" class="px-3 py-1.5 text-sm font-medium text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition-colors">삭제</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isModalOpen" x-transition.duration.300ms class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="form.id ? '배너 수정' : '새 배너 등록'"></h3>
                                <div class="mt-6 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">PC 이미지 (필수)</label>
                                            <div class="mt-1 flex items-center">
                                                <div class="h-20 w-40 border border-gray-300 rounded overflow-hidden bg-gray-50 flex items-center justify-center">
                                                    <img x-show="form.pc_image" :src="form.pc_image" class="h-full object-cover">
                                                    <span x-show="!form.pc_image" class="text-xs text-gray-400">이미지 없음</span>
                                                </div>
                                                <div class="ml-4 relative">
                                                    <button type="button" class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">업로드</button>
                                                    <input type="file" @change="uploadImage($event, 'pc_image')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Mobile 이미지</label>
                                            <div class="mt-1 flex items-center">
                                                <div class="h-20 w-20 border border-gray-300 rounded overflow-hidden bg-gray-50 flex items-center justify-center">
                                                    <img x-show="form.mobile_image" :src="form.mobile_image" class="h-full object-cover">
                                                    <span x-show="!form.mobile_image" class="text-xs text-center text-gray-400">없음</span>
                                                </div>
                                                <div class="ml-4 relative">
                                                    <button type="button" class="px-3 py-1 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">업로드</button>
                                                    <input type="file" @change="uploadImage($event, 'mobile_image')" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">노출 순서</label>
                                            <input type="number" x-model.number="form.sort_order" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">노출 여부</label>
                                            <select x-model="form.is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option :value="true">노출함</option>
                                                <option :value="false">노출안함</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="button" @click="saveBanner()" :disabled="saving" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                            저장
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
            Alpine.data('bannersManager', () => ({
                banners: [],
                isModalOpen: false,
                saving: false,
                form: {
                    id: null,
                    pc_image: '',
                    mobile_image: '',
                    sort_order: 0,
                    start_date: '',
                    end_date: '',
                    is_active: true
                },

                fetchBanners() {
                    axios.post('/api/admin/banners/list', {}, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        this.banners = response.data.data;
                        this.$nextTick(() => { this.initSortable(); });
                    }).catch(error => {
                        alert('배너 목록을 불러오는데 실패했습니다.');
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
                                // re-calculate sort_orders based on new DOM position
                                const itemEls = Array.from(this.$refs.sortableList.children).filter(el => el.hasAttribute('data-id'));
                                const newOrder = itemEls.map((el, index) => ({
                                    id: parseInt(el.getAttribute('data-id')),
                                    sort_order: index + 1
                                }));
                                this.saveOrder(newOrder);
                            }
                        });
                    }
                },

                saveOrder(newOrder) {
                    axios.post('/api/admin/banners/reorder', { items: newOrder }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => {
                        if(res.data.success) {
                            // Update local models softly without full refresh if possible, or just fetch:
                            this.fetchBanners();
                        }
                    }).catch(err => {
                        console.error('순서 저장 오류:', err);
                        alert('순서 저장에 실패했습니다.');
                    });
                },

                openModal(banner = null) {
                    if(banner) {
                        this.form = { ...banner, start_date: banner.start_date || '', end_date: banner.end_date || '' };
                    } else {
                        const maxOrder = this.banners.length > 0 ? Math.max(...this.banners.map(b => b.sort_order)) + 1 : 1;
                        this.form = { id: null, pc_image: '', mobile_image: '', sort_order: maxOrder, start_date: '', end_date: '', is_active: true };
                    }
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                uploadImage(event, field) {
                    const file = event.target.files[0];
                    if(!file) return;

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('folder', 'slide');
                    event.target.value = '';

                    axios.post('/api/admin/upload', formData).then(response => {
                        if(response.data.success) {
                            this.form[field] = response.data.url;
                        } else {
                            alert(response.data.message);
                        }
                    }).catch(err => {
                        alert('이미지 업로드 오류');
                    });
                },

                saveBanner() {
                    if(!this.form.pc_image) {
                        alert('PC 이미지는 필수입니다.'); return;
                    }
                    this.saving = true;
                    const url = this.form.id ? '/api/admin/banners/update' : '/api/admin/banners/store';

                    axios.post(url, this.form, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        if(response.data.success) {
                            this.closeModal();
                            this.fetchBanners();
                        }
                    }).catch(error => {
                        alert('배너 저장에 실패했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                },

                deleteBanner(id) {
                    if(confirm('이 배너를 삭제하시겠습니까?')) {
                        axios.post('/api/admin/banners/delete', { id }).then(res => {
                            this.fetchBanners();
                        }).catch(err => alert('삭제 실패'));
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
