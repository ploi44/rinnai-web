<x-admin.layout>
    <x-slot name="header">
        주요안내 관리
    </x-slot>

    <!-- Page Alert -->
    <div class="mb-6 rounded-xl bg-blue-50 p-4 border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">사이트 메인 페이지 등에 노출되는 주요안내(Notice)를 관리합니다. 마우스 드래그 앤 드롭으로 노출 순서를 즉시 변경할 수 있습니다.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="noticesManager()" x-init="fetchNotices()">
        <!-- Toolbar -->
        <div class="flex justify-end items-center p-6 border-b border-gray-100 bg-white">
            <button @click="openModal()" class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                새 주요안내 등록
            </button>
        </div>

        <!-- Notices List -->
        <div class="p-6 bg-gray-50/50 min-h-[400px]">
            <template x-if="notices.length === 0">
                <div class="py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 rounded-xl bg-white">
                    <p>등록된 주요안내가 없습니다.</p>
                </div>
            </template>

            <div class="space-y-3" x-ref="sortableList">
                <template x-for="notice in notices" :key="notice.id">
                    <div class="flex items-start bg-white border border-gray-200 rounded-xl p-4 transition-shadow hover:shadow-md" :data-id="notice.id">
                        <!-- Drag Handle -->
                        <div class="handle cursor-grab active:cursor-grabbing p-2 mt-1 mr-3 text-gray-400 hover:text-gray-600 shrink-0 bg-gray-50 rounded">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </div>

                        <div class="flex-1 min-w-0 pr-4">
                            <h4 class="text-base font-bold text-gray-900 mb-1" x-text="notice.title"></h4>
                            <div class="whitespace-pre-wrap text-sm text-gray-600 mb-3" x-html="notice.content"></div>

                            <!-- Notice Metadata -->
                            <div class="flex items-center space-x-4 text-xs">
                                <span class="flex items-center text-gray-500" x-show="notice.link_url">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    <a :href="notice.link_url" target="_blank" class="text-blue-500 hover:underline truncate max-w-xs" x-text="notice.link_url"></a>
                                </span>
                                <span class="text-gray-500 bg-gray-100 px-2 py-0.5 rounded font-mono">Order: <span x-text="notice.sort_order"></span></span>
                                <span :class="notice.is_active ? 'text-green-600 bg-green-50' : 'text-rose-500 bg-rose-50'" class="px-2 py-0.5 rounded font-bold" x-text="notice.is_active ? '노출중' : '숨김'"></span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col space-y-2 shrink-0 border-l border-gray-100 pl-4 ml-2">
                            <button @click="openModal(notice)" class="px-4 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 border border-blue-200 rounded transition-colors w-full text-center">수정</button>
                            <button @click="deleteNotice(notice.id)" class="px-4 py-1.5 text-sm font-medium text-rose-600 hover:text-rose-700 hover:bg-rose-50 border border-rose-200 rounded transition-colors w-full text-center">삭제</button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Modal Form -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isModalOpen" x-transition.duration.300ms class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-xl leading-6 font-bold text-gray-900 border-b pb-4 mb-5" id="modal-title" x-text="form.id ? '주요안내 수정' : '새 주요안내 등록'"></h3>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1.5">제목 <span class="text-rose-500">*</span></label>
                                <input type="text" x-model="form.title" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="안내 제목을 입력하세요">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1.5">상세 내용 <span class="text-rose-500">*</span></label>
                                <textarea x-model="form.content" rows="4" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="상세 안내 내용을 입력하세요..."></textarea>
                                <p class="mt-1 text-xs text-gray-500">Enter 키를 사용하여 줄바꿈을 적용할 수 있습니다.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1.5">링크 주소(URL)</label>
                                <input type="text" x-model="form.link_url" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="https://...">
                            </div>

                            <div class="grid grid-cols-2 gap-6 bg-slate-50 p-4 rounded-lg border border-slate-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1.5">상태 (노출 여부)</label>
                                    <select x-model="form.is_active"
                                            @change="form.is_active = ($event.target.value === 'true')"
                                            class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option :value="true">노출함 (Active)</option>
                                        <option :value="false">숨김 (Inactive)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-900 mb-1.5">우선 순위 (노출 순서)</label>
                                    <input type="number" x-model.number="form.sort_order" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="button" @click="saveNotice()" :disabled="saving" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 transition-colors">
                            저장하기
                        </button>
                        <button type="button" @click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
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
            Alpine.data('noticesManager', () => ({
                notices: [],
                sortableInstance: null,
                isModalOpen: false,
                saving: false,
                form: {
                    id: null,
                    title: '',
                    content: '',
                    link_url: '',
                    sort_order: 1,
                    is_active: true
                },

                fetchNotices() {
                    axios.post('/api/admin/notices/list', {}, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        this.notices = response.data.data;
                        this.$nextTick(() => { this.initSortable(); });
                    }).catch(error => {
                        console.error(error);
                        alert('주요안내 목록을 불러오는데 실패했습니다.');
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
                    axios.post('/api/admin/notices/reorder', { items: newOrder }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => {
                        if(res.data.success) {
                            this.fetchNotices();
                        }
                    }).catch(err => {
                        console.error('순서 저장 오류:', err);
                        alert('순서 저장에 실패했습니다.');
                    });
                },

                openModal(notice = null) {
                    if(notice) {
                        this.form = { ...notice, content: notice.content };
                    } else {
                        const maxOrder = this.notices.length > 0 ? Math.max(...this.notices.map(n => n.sort_order || 0)) + 1 : 1;
                        this.form = { id: null, title: '', content: '', link_url: '', sort_order: maxOrder, is_active: true };
                    }
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                saveNotice() {
                    if(!this.form.title.trim() || !this.form.content.trim()) {
                        alert('제목과 내용은 필수 항목입니다.'); return;
                    }

                    this.saving = true;
                    const url = this.form.id ? '/api/admin/notices/update' : '/api/admin/notices/store';

                    axios.post(url, this.form, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        if(response.data.success) {
                            this.closeModal();
                            this.fetchNotices();
                        }
                    }).catch(error => {
                        console.error(error);
                        alert(error.response?.data?.message || '저장에 실패했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                },

                deleteNotice(id) {
                    if(confirm('이 안내글을 완전히 삭제하시겠습니까?')) {
                        axios.post('/api/admin/notices/delete', { id }).then(res => {
                            this.fetchNotices();
                        }).catch(err => {
                            console.error(err);
                            alert('삭제 실패');
                        });
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
