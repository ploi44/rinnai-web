<x-admin.layout>
    <x-slot name="header">
        팝업 관리
    </x-slot>

    <!-- Page Alert -->
    <div class="mb-6 rounded-xl bg-blue-50 p-4 border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">메인 화면 접속 시 노출되는 이벤트/공지용 팝업을 관리할 수 있습니다.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="popupsManager()" x-init="fetchPopups()">
        <!-- Toolbar -->
        <div class="flex justify-end items-center p-6 border-b border-gray-100">
            <button @click="openModal()" class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                새 팝업 등록
            </button>
        </div>

        <!-- Popup List -->
        <div class="p-6">
            <template x-if="popups.length === 0">
                <div class="py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 rounded-xl">
                    <p>등록된 팝업이 없습니다.</p>
                </div>
            </template>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-ref="sortableList">
                <template x-for="popup in popups" :key="popup.id">
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition-shadow flex flex-col relative" :data-id="popup.id">
                        <!-- Drag Handle -->
                        <div class="absolute top-2 left-2 z-10 handle cursor-grab active:cursor-grabbing p-1 bg-white/80 rounded text-gray-500 hover:text-gray-900 shadow-sm border border-gray-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </div>
                        <div class="h-40 bg-gray-100 relative group overflow-hidden flex items-center justify-center">
                            <template x-if="popup.image">
                                <img :src="popup.image" class="h-full object-contain">
                            </template>
                            <span x-show="!popup.image" class="text-gray-400">이미지 없음</span>
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-bold rounded-md shadow-sm" :class="popup.is_active ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700'" x-text="popup.is_active ? '사용중' : '미사용'"></span>
                            </div>
                        </div>
                        <div class="p-4 flex-1 flex flex-col">
                            <h4 class="font-bold text-gray-900 truncate" x-text="popup.title || '제목 없음'"></h4>
                            <p class="text-xs text-gray-500 mt-2">기간: <span x-text="popup.start_date ? popup.start_date.substring(0, 10) : '제한없음'"></span> ~ <span x-text="popup.end_date ? popup.end_date.substring(0, 10) : '제한없음'"></span></p>
                            <p class="text-xs text-blue-500 mt-1 truncate hover:underline"><a :href="popup.link" target="_blank" x-text="popup.link || '연결 링크 없음'"></a></p>
                        </div>
                        <div class="border-t border-gray-100 p-3 bg-gray-50 flex justify-between">
                            <button @click="deletePopup(popup.id)" class="text-sm text-rose-600 hover:text-rose-800 font-medium px-2">삭제</button>
                            <button @click="openModal(popup)" class="text-sm text-blue-600 hover:text-blue-800 font-medium px-4 py-1.5 border border-blue-200 bg-white rounded shadow-sm hover:bg-blue-50 transition-colors">수정</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Modal -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start w-full">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" x-text="form.id ? '팝업 수정' : '새 팝업 등록'"></h3>
                                <div class="mt-6 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">팝업 제목</label>
                                            <input type="text" x-model="form.title" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">노출 순서</label>
                                            <input type="number" x-model.number="form.sort_order" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">팝업 이미지 (필수)</label>
                                        <div class="h-32 w-full border border-gray-300 rounded overflow-hidden bg-gray-50 flex items-center justify-center relative mb-2">
                                            <img x-show="form.image" :src="form.image" class="h-full object-contain">
                                            <span x-show="!form.image" class="text-sm text-gray-400">이미지를 업로드하세요</span>
                                        </div>
                                        <div class="relative w-full">
                                            <button type="button" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50 font-medium">로컬PC에서 가져오기...</button>
                                            <input type="file" @change="uploadImage" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">클릭 연결 링크</label>
                                            <input type="text" x-model="form.link" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="https://...">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">열기 설정</label>
                                            <select x-model="form.target" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="_self">현재 창</option>
                                                <option value="_blank">새 창</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">X 위치 (px)</label>
                                            <input type="number" x-model.number="form.position_x" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Y 위치 (px)</label>
                                            <input type="number" x-model.number="form.position_y" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">너비 (px)</label>
                                            <input type="number" min="1" x-model.number="form.width" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">높이 (px)</label>
                                            <input type="number" min="1" x-model.number="form.height" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">노출 시작일</label>
                                            <input type="date" x-model="form.start_date" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer" onkeydown="return false" onclick="this.showPicker()">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">노출 종료일</label>
                                            <input type="date" x-model="form.end_date" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm cursor-pointer" onkeydown="return false" onclick="this.showPicker()">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">상태 (노출여부)</label>
                                            <select x-model="form.is_active"
                                                    @change="form.is_active = ($event.target.value === 'true')"
                                                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option :value="true">사용함</option>
                                                <option :value="false">미사용</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="button" @click="savePopup()" :disabled="saving" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
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
            Alpine.data('popupsManager', () => ({
                popups: [],
                isModalOpen: false,
                saving: false,
                form: {
                    id: null,
                    title: '',
                    image: '',
                    link: '',
                    target: '_self',
                    position_x: 0,
                    position_y: 0,
                    width: null,
                    height: null,
                    start_date: '',
                    end_date: '',
                    is_active: true
                },

                fetchPopups() {
                    axios.post('/api/admin/popups/list', {}, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        this.popups = response.data.data;
                        this.$nextTick(() => { this.initSortable(); });
                    }).catch(error => {
                        alert('팝업 목록을 불러오는데 실패했습니다.');
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
                                    sort_order: index + 1
                                }));
                                this.saveOrder(newOrder);
                            }
                        });
                    }
                },

                saveOrder(newOrder) {
                    axios.post('/api/admin/popups/reorder', { items: newOrder }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => {
                        if(res.data.success) {
                            this.fetchPopups();
                        }
                    }).catch(err => {
                        console.error('순서 저장 오류:', err);
                        alert('순서 저장에 실패했습니다.');
                    });
                },

                openModal(popup = null) {
                    if(popup) {
                        this.form = { ...popup, start_date: popup.start_date || '', end_date: popup.end_date || '', sort_order: popup.sort_order || 0 };
                    } else {
                        const maxOrder = this.popups.length > 0 ? Math.max(...this.popups.map(p => p.sort_order || 0)) + 1 : 1;
                        this.form = { id: null, title: '', image: '', link: '', target: '_self', position_x: 0, position_y: 0, width: null, height: null, start_date: '', end_date: '', is_active: true, sort_order: maxOrder };
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
                    formData.append('folder', 'popup');
                    event.target.value = '';

                    axios.post('/api/admin/upload', formData).then(response => {
                        if(response.data.success) {
                            this.form.image = response.data.url;
                        } else {
                            alert(response.data.message);
                        }
                    }).catch(err => {
                        alert('이미지 업로드 오류');
                    });
                },

                async savePopup() {
                    if(!this.form.image) {
                        alert('이미지는 필수입니다.'); return;
                    }

                    // 빈 값일 경우 이미지 원본 비율 계산
                    let valW = this.form.width;
                    let valH = this.form.height;
                    let isWEmpty = valW === null || valW === '' || valW === undefined;
                    let isHEmpty = valH === null || valH === '' || valH === undefined;

                    if (isWEmpty || isHEmpty) {
                        let dim = await new Promise((resolve) => {
                            const img = new Image();
                            img.onload = () => resolve({ w: img.width, h: img.height });
                            img.onerror = () => resolve(null);
                            img.src = this.form.image;
                        });

                        if (dim) {
                            if (isWEmpty && isHEmpty) {
                                this.form.width = dim.w;
                                this.form.height = dim.h;
                            } else if (!isWEmpty && isHEmpty) {
                                this.form.height = Math.round(parseInt(valW) * (dim.h / dim.w));
                            } else if (isWEmpty && !isHEmpty) {
                                this.form.width = Math.round(parseInt(valH) * (dim.w / dim.h));
                            }
                        }
                    }

                    if(this.form.width !== null && this.form.width !== '' && this.form.width <= 0) {
                        alert('가로 크기는 0보다 커야 합니다.'); return;
                    }
                    if(this.form.height !== null && this.form.height !== '' && this.form.height <= 0) {
                        alert('세로 크기는 0보다 커야 합니다.'); return;
                    }

                    if(this.form.start_date && this.form.end_date) {
                        if(this.form.start_date > this.form.end_date) {
                            alert('종료일은 시작일보다 빠를 수 없습니다.');
                            return;
                        }
                    }
                    this.saving = true;
                    // id가 있으면 update, 없으면 store API 호출
                    const url = this.form.id ? '/api/admin/popups/update' : '/api/admin/popups/store';

                    axios.post(url, Object.assign({}, this.form), {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        if(response.data.success) {
                            this.closeModal();
                            this.fetchPopups();
                        }
                    }).catch(error => {
                        alert('저장에 실패했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                },

                deletePopup(id) {
                    if(confirm('이 팝업을 정말로 삭제하시겠습니까?')) {
                        axios.post('/api/admin/popups/delete', { id }).then(res => {
                            this.fetchPopups();
                        }).catch(err => alert('삭제 실패'));
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
