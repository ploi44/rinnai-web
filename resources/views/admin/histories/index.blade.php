<x-admin.layout>
    <x-slot name="header">
        연혁 관리
    </x-slot>

    <!-- Page Alert -->
    <div class="mb-6 rounded-xl bg-blue-50 p-4 border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">회사의 연혁을 관리합니다. 연도별로 내용이 자동으로 그룹핑되며, 같은 연도 내에서 드래그 앤 드롭으로 순서를 변경할 수 있습니다.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="historiesManager()" x-init="fetchHistories()">
        <!-- Toolbar -->
        <div class="flex justify-end items-center p-6 border-b border-gray-100 bg-white">
            <button @click="openModal()" class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                새 연혁 등록
            </button>
        </div>

        <!-- Histories List Grouped -->
        <div class="p-6 bg-gray-50/50 min-h-[400px]">
            <template x-if="histories.length === 0">
                <div class="py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 rounded-xl bg-white">
                    <p>등록된 연혁이 없습니다.</p>
                </div>
            </template>

            <!-- Grouped by Year -->
            <div class="space-y-8">
                <template x-for="year in sortedYears" :key="year">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-slate-800 text-white px-6 py-3 border-b flex items-center justify-between">
                            <h3 class="text-lg font-bold" x-text="year + '년'"></h3>
                            <span class="text-xs text-slate-300 bg-slate-700 px-2 py-1 rounded" x-text="groupedHistories[year].length + '개 항목'"></span>
                        </div>
                        <div class="p-4 bg-gray-50/30">
                            <div class="space-y-3 sortable-group" :data-year="year">
                                <template x-for="history in groupedHistories[year]" :key="history.id">
                                    <div class="flex items-start bg-white border border-gray-200 rounded-xl p-4 transition-shadow hover:shadow-md" :data-id="history.id">
                                        <div class="handle cursor-grab active:cursor-grabbing p-2 mt-1 mr-2 text-gray-400 hover:text-gray-600 shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                        </div>
                                        <div class="flex-1 min-w-0 pr-4">
                                            <div class="whitespace-pre-wrap text-sm text-gray-800 leading-relaxed font-medium" x-html="history.content"></div>
                                            <div class="mt-3 flex items-center space-x-3 text-xs">
                                                <span class="text-gray-500 bg-gray-100 px-2 py-0.5 rounded font-mono">Order: <span x-text="history.sort_order"></span></span>
                                                <span :class="history.is_active ? 'text-green-600 bg-green-50' : 'text-rose-500 bg-rose-50'" class="px-2 py-0.5 rounded font-bold" x-text="history.is_active ? '노출중' : '숨김'"></span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col space-y-2 shrink-0 border-l border-gray-100 pl-4 ml-2">
                                            <button @click="openModal(history)" class="px-3 py-1 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded transition-colors w-full text-center">수정</button>
                                            <button @click="deleteHistory(history.id)" class="px-3 py-1 text-sm font-medium text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded transition-colors w-full text-center">삭제</button>
                                        </div>
                                    </div>
                                </template>
                            </div>
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
                <div x-show="isModalOpen" x-transition.duration.300ms class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-semibold text-gray-900 mb-6" id="modal-title" x-text="form.id ? '연혁 수정' : '새 연혁 등록'"></h3>

                        <div class="space-y-5">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">연도 (Year) <span class="text-rose-500">*</span></label>
                                    <input type="text" x-model="form.year"
                                           class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-mono" placeholder="예: 2026">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">상태</label>
                                    <select x-model="form.is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option :value="true">노출함</option>
                                        <option :value="false">숨김</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">연혁 내용 <span class="text-rose-500">*</span></label>
                                <textarea x-model="form.content" rows="4" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="연혁 내용을 입력하세요..."></textarea>
                                <p class="mt-1 text-xs text-gray-500">줄바꿈(Enter)이 그대로 적용되어 화면에 표시됩니다.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">연도 내 노출 순서</label>
                                <input type="number" x-model.number="form.sort_order" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="button" @click="saveHistory()" :disabled="saving" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
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
            Alpine.data('historiesManager', () => ({
                histories: [],
                sortableInstances: [],
                isModalOpen: false,
                saving: false,
                form: {
                    id: null,
                    year: new Date().getFullYear().toString(),
                    content: '',
                    sort_order: 1,
                    is_active: true
                },

                get groupedHistories() {
                    return this.histories.reduce((groups, item) => {
                        (groups[item.year] = groups[item.year] || []).push(item);
                        return groups;
                    }, {});
                },

                get sortedYears() {
                    return Object.keys(this.groupedHistories).sort((a,b) => a - b);
                },

                fetchHistories() {
                    axios.post('/api/admin/histories/list', {}, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        this.histories = response.data.data;
                        this.$nextTick(() => { this.initSortables(); });
                    }).catch(error => {
                        alert('연혁 목록을 불러오는데 실패했습니다.');
                    });
                },

                initSortables() {
                    // Destroy previous instances
                    this.sortableInstances.forEach(inst => inst.destroy());
                    this.sortableInstances = [];

                    // Re-init for each year group
                    const groups = document.querySelectorAll('.sortable-group');
                    groups.forEach(groupEl => {
                        const instance = new Sortable(groupEl, {
                            handle: '.handle',
                            animation: 150,
                            onEnd: (evt) => {
                                const itemEls = Array.from(groupEl.children).filter(el => el.hasAttribute('data-id'));
                                const newOrder = itemEls.map((el, index) => ({
                                    id: parseInt(el.getAttribute('data-id')),
                                    sort_order: index + 1
                                }));
                                this.saveOrder(newOrder);
                            }
                        });
                        this.sortableInstances.push(instance);
                    });
                },

                saveOrder(newOrder) {
                    axios.post('/api/admin/histories/reorder', { items: newOrder }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(res => {
                        if(res.data.success) {
                            this.fetchHistories();
                        }
                    }).catch(err => {
                        console.error('순서 저장 오류:', err);
                        alert('순서 저장에 실패했습니다.');
                    });
                },

                openModal(history = null) {
                    if(history) {
                        this.form = { ...history, content: history.content };
                    } else {
                        const yearInput = this.form.year;
                        // Determine next sort order for this year
                        const itemsInYear = this.groupedHistories[yearInput] || [];
                        const maxOrder = itemsInYear.length > 0 ? Math.max(...itemsInYear.map(h => h.sort_order || 0)) + 1 : 1;

                        this.form = { id: null, year: yearInput, content: '', sort_order: maxOrder, is_active: true };
                    }
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                saveHistory() {
                    if(!this.form.year || !this.form.content) {
                        alert('연도와 내용은 필수입니다.'); return;
                    }

                    this.saving = true;
                    const url = this.form.id ? '/api/admin/histories/update' : '/api/admin/histories/store';

                    axios.post(url, this.form, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        if(response.data.success) {
                            this.closeModal();
                            this.fetchHistories();
                        }
                    }).catch(error => {
                        alert(error.response?.data?.message || '저장에 실패했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                },

                deleteHistory(id) {
                    if(confirm('이 연혁을 삭제하시겠습니까?')) {
                        axios.post('/api/admin/histories/delete', { id }).then(res => {
                            this.fetchHistories();
                        }).catch(err => alert('삭제 실패'));
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
