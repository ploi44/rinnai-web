<x-admin.layout>
    <x-slot name="header">
        계정 관리
    </x-slot>

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

            <button class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
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
                        <th class="px-6 py-4 font-medium">권한 (Level)</th>
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
                                <select x-model="user.level" @change="updateLevel(user.id, $event.target.value)" class="text-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-lg">
                                    <option value="1">일반 회원 (1)</option>
                                    <option value="5">매니저 (5)</option>
                                    <option value="10">최고관리자 (10)</option>
                                </select>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium border"
                                      :class="user.status === 'inactive' ? 'bg-gray-100 text-gray-600 border-gray-200' : 'bg-green-50 text-green-700 border-green-200'"
                                      x-text="user.status === 'inactive' ? '비활성' : '활성'">
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                <div class="text-gray-900" x-text="new Date(user.created_at).toLocaleDateString()"></div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <button class="text-rose-600 hover:text-rose-900 mx-1 p-1 rounded hover:bg-rose-50 transition-colors">삭제</button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="users.length === 0">
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">검색 결과가 없습니다.</td>
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

                updateLevel(id, level) {
                    axios.post('/api/admin/accounts/update', {
                        id: id,
                        level: level
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        // success
                    }).catch(error => {
                        console.error(error);
                        alert('권한 수정에 실패했습니다.');
                        this.fetchAccounts(); // revert
                    });
                }
            }));
        });
    </script>
</x-admin.layout>
