<x-admin.layout>
    <x-slot name="header">
        게시판 관리
    </x-slot>

    <!-- Page Alert -->
    <div class="mb-6 rounded-xl bg-blue-50 p-4 border border-blue-100">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">사이트 내 모든 유형(일반, 앨범, 유튜브형)의 게시판을 생성하고 관리할 수 있습니다.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="boardsManager()" x-init="fetchBoards()">
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row justify-between items-center p-6 border-b border-gray-100 gap-4">
            <div class="flex items-center w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" x-model="search" @keydown.enter="page=1; fetchBoards()" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="게시판 이름 검색...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <select x-model="type" @change="page=1; fetchBoards()" class="ml-3 block w-32 pl-3 pr-10 py-2 text-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-lg text-gray-600">
                    <option value="">전체 타입</option>
                    <option value="general">일반게시판</option>
                    <option value="album">앨범형</option>
                </select>
                <button @click="page=1; fetchBoards()" class="ml-3 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    검색
                </button>
            </div>
            <a href="{{ route('admin.boards.create') }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                새 게시판 생성
            </a>
        </div>

        <!-- Board List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID(Slug)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">게시판 형태</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">게시판 이름</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">읽기/쓰기 권한</th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">상태</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">생성일</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">관리</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="board in boards" :key="board.id">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="board.slug"></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium border"
                                      :class="board.type === 'album' ? 'bg-purple-50 text-purple-700 border-purple-200' : 'bg-blue-50 text-blue-700 border-blue-200'"
                                      x-text="board.type === 'album' ? '앨범형' : '일반형'">
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 font-bold" x-text="board.name"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center font-medium">
                                <span x-text="'R:' + board.read_level + ' / W:' + board.write_level"></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">사용</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="new Date(board.created_at).toLocaleDateString()">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button @click="deleteBoard(board.id)" class="text-rose-600 hover:text-rose-900 px-2">삭제</button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="boards.length === 0">
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">등록된 게시판이 없습니다.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between" x-show="total > 0">
            <div class="text-sm text-gray-500">
                총 <span class="font-medium text-gray-900" x-text="total"></span>개 중 페이지 <span class="font-medium text-gray-900" x-text="page"></span>/<span class="font-medium text-gray-900" x-text="lastPage"></span>
            </div>
            <div class="flex space-x-1">
                <button @click="if(page > 1) { page--; fetchBoards(); }" :disabled="page <= 1" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">이전</button>
                <button @click="if(page < lastPage) { page++; fetchBoards(); }" :disabled="page >= lastPage" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">다음</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('boardsManager', () => ({
                boards: [],
                search: '',
                type: '',
                page: 1,
                lastPage: 1,
                total: 0,

                fetchBoards() {
                    axios.post('/api/admin/boards/list', {
                        search: this.search,
                        type: this.type,
                        page: this.page
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        const res = response.data.data;
                        this.boards = res.data;
                        this.page = res.current_page;
                        this.lastPage = res.last_page;
                        this.total = res.total;
                    }).catch(error => {
                        console.error(error);
                        alert('게시판 목록을 불러오는데 실패했습니다.');
                    });
                },

                deleteBoard(id) {
                    if (confirm('정말로 이 게시판을 삭제하시겠습니까? 관련된 모든 데이터가 삭제됩니다.')) {
                        axios.post('/api/admin/boards/delete', {
                            id: id
                        }, {
                            headers: { 'Content-Type': 'application/json' }
                        }).then(response => {
                            alert('삭제되었습니다.');
                            this.fetchBoards();
                        }).catch(error => {
                            console.error(error);
                            alert('게시판 삭제에 실패했습니다.');
                        });
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
