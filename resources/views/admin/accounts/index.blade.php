<x-admin.layout>
    <x-slot name="header">
        계정 관리
    </x-slot>

    <div class="mb-5 rounded-xl bg-blue-50 p-4 border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">관리자 계정을 등록하고 수정 또는 삭제할 수 있습니다. 본인 계정은 삭제할 수 없습니다.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="accountsManager()" x-init="fetchAccounts()">
        <!-- Toolbar -->
        <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" x-model="search" @keydown.enter="page=1; fetchAccounts()" class="block w-full sm:w-64 pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500" placeholder="이름, 이메일 검색...">
                </div>
                <select x-model="status" @change="page=1; fetchAccounts()" class="block w-full sm:w-32 pl-3 pr-10 py-2 text-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-lg">
                    <option value="">전체 상태</option>
                    <option value="active">활성</option>
                    <option value="inactive">비활성</option>
                </select>
                <button @click="page=1; fetchAccounts()" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    검색
                </button>
            </div>

            <button @click="openModal()" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                계정 등록
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-medium">사용자 정보</th>
                        <th class="px-6 py-4 font-medium">상태</th>
                        <th class="px-6 py-4 font-medium">가입일</th>
                        <th class="px-6 py-4 font-medium text-right">관리</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    <template x-for="user in users" :key="user.id">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200" x-text="user.name.charAt(0)">
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900" x-text="user.name"></div>
                                        <div class="text-gray-500" x-text="user.email"></div>
                                        <div class="text-xs text-gray-400" x-text="'ID: ' + (user.user_id || '-')"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <label class="flex items-center cursor-pointer">
                                    <div class="relative">
                                        <input type="checkbox" x-model="user.is_active" @change="updateStatus(user.id, user.is_active)" class="sr-only">
                                        <div class="block bg-gray-200 w-10 h-6 rounded-full transition-colors duration-200" :class="{ 'bg-blue-500': user.is_active }"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200" :class="{ 'transform translate-x-4': user.is_active }"></div>
                                    </div>
                                    <span class="ml-3 text-sm font-medium" :class="user.is_active ? 'text-blue-600' : 'text-gray-500'" x-text="user.is_active ? '활성' : '비활성'"></span>
                                </label>
                            </td>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900" x-text="new Date(user.created_at).toLocaleDateString()"></div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <button @click="openModal(user)" class="text-blue-600 hover:text-blue-900 mx-1 p-1 rounded hover:bg-blue-50 transition-colors">수정</button>
                                <button @click="deleteAccount(user.id)" class="text-rose-600 hover:text-rose-900 mx-1 p-1 rounded hover:bg-rose-50 transition-colors">삭제</button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="users.length === 0">
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">검색 결과가 없습니다.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between" x-show="total > 0">
            <div class="text-sm text-gray-500">
                총 <span class="font-medium text-gray-900" x-text="total"></span>명 중 페이지 <span class="font-medium text-gray-900" x-text="page"></span>/<span class="font-medium text-gray-900" x-text="lastPage"></span>
            </div>
            <div class="flex space-x-1">
                <button @click="if(page > 1) { page--; fetchAccounts(); }" :disabled="page <= 1" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">이전</button>
                <button @click="if(page < lastPage) { page++; fetchAccounts(); }" :disabled="page >= lastPage" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">다음</button>
            </div>
        </div>

        <!-- Modal Form -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isModalOpen" x-transition.duration.300ms class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-xl leading-6 font-bold text-gray-900 border-b pb-4 mb-5" id="modal-title" x-text="form.id ? '계정 수정' : '새 계정 등록'"></h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">이름 <span class="text-rose-500">*</span></label>
                                <input type="text" x-model="form.name" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="관리자 이름">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">아이디(ID) <span class="text-rose-500" x-show="!form.id">*</span></label>
                                <input type="text" x-model="form.user_id" :disabled="form.id !== null" :class="{'bg-gray-100': form.id !== null}" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="로그인 아이디">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">이메일 <span class="text-rose-500">*</span></label>
                                <input type="email" x-model="form.email" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="admin@example.com">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-900 mb-1">
                                    비밀번호 <span class="text-rose-500" x-show="!form.id">*</span>
                                    <span class="text-xs text-gray-500 ml-1" x-show="form.id">(변경하지 않으려면 비워두세요)</span>
                                </label>
                                <input type="password" x-model="form.password" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="비밀번호 (최소 4자 이상)">
                            </div>
                            
                            <div class="pt-2">
                                <label class="block text-sm font-medium text-gray-900 mb-2">계정 상태</label>
                                <div class="flex items-center space-x-4 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                    <label class="flex items-center">
                                        <input type="radio" x-model="form.is_active" :value="true" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-900">활성 (로그인 가능)</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" x-model="form.is_active" :value="false" class="h-4 w-4 text-rose-600 focus:ring-rose-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-900">비활성 (잠금)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6 flex flex-row-reverse border-t border-gray-100 gap-2">
                        <button type="button" @click="saveAccount()" :disabled="saving" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-6 py-2.5 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:max-w-max sm:text-sm disabled:opacity-50 transition-colors">
                            저장하기
                        </button>
                        <button type="button" @click="closeModal()" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:max-w-max sm:text-sm transition-colors">
                            취소
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('accountsManager', () => ({
                users: [],
                search: '',
                status: '',
                page: 1,
                lastPage: 1,
                total: 0,
                
                isModalOpen: false,
                saving: false,
                form: {
                    id: null,
                    name: '',
                    user_id: '',
                    email: '',
                    password: '',
                    is_active: true
                },

                fetchAccounts() {
                    axios.post('/api/admin/accounts/list', {
                        search: this.search,
                        status: this.status,
                        page: this.page
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        const res = response.data.data;
                        this.users = res.data;
                        this.page = res.current_page;
                        this.lastPage = res.last_page;
                        this.total = res.total;
                    }).catch(error => {
                        console.error(error);
                        alert('데이터를 불러오는데 실패했습니다.');
                    });
                },

                updateStatus(id, isActive) {
                    axios.post('/api/admin/accounts/update', {
                        id: id,
                        is_active: isActive
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        // success
                    }).catch(error => {
                        console.error(error);
                        alert('상태 변경에 실패했습니다.');
                        this.fetchAccounts(); // revert
                    });
                },

                openModal(user = null) {
                    if(user) {
                        this.form = {
                            id: user.id,
                            name: user.name,
                            user_id: user.user_id, // user_id cannot be edited typically but we need to display it
                            email: user.email,
                            password: '', // Blank by default, only update if filled
                            is_active: user.is_active
                        };
                    } else {
                        this.form = { id: null, name: '', user_id: '', email: '', password: '', is_active: true };
                    }
                    this.isModalOpen = true;
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                saveAccount() {
                    if(!this.form.name.trim() || !this.form.email.trim() || (!this.form.id && !this.form.password.trim()) || (!this.form.id && !this.form.user_id?.trim())) {
                        alert('필수 항목을 모두 입력해주세요.'); return;
                    }
                    
                    this.saving = true;
                    const url = this.form.id ? '/api/admin/accounts/update' : '/api/admin/accounts/store';

                    axios.post(url, this.form, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        if(response.data.success) {
                            this.closeModal();
                            this.fetchAccounts();
                        }
                    }).catch(error => {
                        console.error(error);
                        alert(error.response?.data?.message || '저장에 실패했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                },

                deleteAccount(id) {
                    if(confirm('이 계정을 완전히 삭제하시겠습니까? 관련 데이터가 소멸될 수 있습니다.')) {
                        axios.post('/api/admin/accounts/delete', { id }).then(res => {
                            if(res.data.success) {
                                this.fetchAccounts();
                            } else {
                                alert(res.data.message || '삭제에 실패했습니다.');
                            }
                        }).catch(err => {
                            console.error(err);
                            alert(err.response?.data?.message || '삭제 실패');
                        });
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
