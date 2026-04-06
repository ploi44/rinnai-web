<x-admin.layout>
    <x-slot name="header">
{{--        <a href="{{ route('admin.boards.index') }}" class="text-blue-500 hover:text-blue-700 mr-2">&larr;</a>--}}
        [{{ $board->name }}] 게시글 관리
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" x-data="postsManager()">
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row justify-between items-center p-6 border-b border-gray-100 gap-4">
            <div class="flex items-center w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" x-model="search" @keydown.enter="page=1; fetchPosts()" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="제목 검색...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                {{--<select x-show="categories.length > 0" x-model="categoryId" @change="page=1; fetchPosts()" class="ml-3 block w-32 pl-3 pr-10 py-2 text-sm border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-lg text-gray-600">
                    <option value="">전체 카테고리</option>
                    <template x-for="cat in categories" :key="cat.id">
                        <option :value="cat.id" x-text="cat.name"></option>
                    </template>
                </select>--}}

                <button @click="page=1; fetchPosts()" class="ml-3 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    검색
                </button>
                {{--<button @click="manageCategoriesModal = true; fetchCategories()" class="ml-3 inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-indigo-50 hover:bg-indigo-100 focus:outline-none transition-colors">
                    카테고리 관리
                </button>--}}
            </div>
            <a href="{{ route('admin.posts.create', ['slug' => $board->slug]) }}" class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                글쓰기
            </a>
        </div>

        <!-- Post List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        {{--<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">카테고리</th>--}}
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">제목</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">작성자</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">작성일</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">관리</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="post in posts" :key="post.id">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" x-text="post.id"></td>
                            {{--<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span x-show="post.category" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800" x-text="post.category ? post.category.name : ''"></span>
                                <span x-show="!post.category" class="text-xs text-gray-400">-</span>
                            </td>--}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900" x-text="post.title"></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="post.user ? post.user.name : '-'"></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" x-text="new Date(post.created_at).toLocaleDateString()">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a :href="'/admin/boards/{{ $board->slug }}/posts/' + post.id + '/edit'" class="text-blue-600 hover:text-blue-900 px-2">수정</a>
                                <button @click="deletePost(post.id)" class="text-rose-600 hover:text-rose-900 px-2">삭제</button>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="posts.length === 0">
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">등록된 게시글이 없습니다.</td>
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
                <button @click="goToPage(1)" :disabled="page <= 1" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50" title="처음">&laquo;</button>
                <button @click="goToPage(page - 1)" :disabled="page <= 1" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">이전</button>

                <template x-for="p in paginationPages" :key="p">
                    <button @click="goToPage(p)"
                            :class="{'bg-blue-600 text-white border-blue-600': p === page, 'bg-white text-gray-500 border-gray-300 hover:bg-gray-50': p !== page}"
                            class="px-3 py-1 border rounded-md" x-text="p"></button>
                </template>

                <button @click="goToPage(page + 1)" :disabled="page >= lastPage" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50">다음</button>
                <button @click="goToPage(lastPage)" :disabled="page >= lastPage" class="px-3 py-1 border border-gray-300 rounded-md bg-white text-gray-500 hover:bg-gray-50 disabled:opacity-50" title="마지막">&raquo;</button>
            </div>
        </div>

        <!-- Category Management Modal -->
        <div x-show="manageCategoriesModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="manageCategoriesModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="manageCategoriesModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="manageCategoriesModal" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">카테고리 관리</h3>

                        <!-- Add Category -->
                        <div class="flex mb-6">
                            <input type="text" x-model="newCategoryName" @keydown.enter="addCategory()" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="새 카테고리 이름">
                            <button @click="addCategory()" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">추가</button>
                        </div>

                        <!-- Category List -->
                        <ul class="divide-y divide-gray-200 border-t border-b border-gray-200 max-h-60 overflow-y-auto">
                            <template x-for="cat in categories" :key="cat.id">
                                <li class="py-3 flex justify-between items-center">
                                    <span x-text="cat.name" class="text-sm font-medium text-gray-900"></span>
                                    <button @click="deleteCategory(cat.id)" class="text-sm text-rose-600 hover:text-rose-900">삭제</button>
                                </li>
                            </template>
                            <li x-show="categories.length === 0" class="py-4 text-center text-sm text-gray-500">등록된 카테고리가 없습니다.</li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="manageCategoriesModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">닫기</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('postsManager', () => ({
                boardId: {{ $board->id }},
                posts: [],
                categories: [],
                search: '',
                categoryId: '',
                page: 1,
                lastPage: 1,
                total: 0,

                manageCategoriesModal: false,
                newCategoryName: '',

                init() {
                    this.fetchCategories();
                    this.fetchPosts();
                },

                get paginationPages() {
                    const pages = [];
                    let start = Math.max(1, this.page - 4);
                    let end = Math.min(this.lastPage, this.page + 4);

                    if (this.lastPage > 9) {
                        if (this.page <= 5) {
                            end = 9;
                        } else if (this.page >= this.lastPage - 4) {
                            start = this.lastPage - 8;
                        }
                    }

                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }
                    return pages;
                },

                goToPage(p) {
                    if (p >= 1 && p <= this.lastPage && p !== this.page) {
                        this.page = p;
                        this.fetchPosts();
                    }
                },

                fetchPosts() {
                    axios.post('/api/admin/posts/list', {
                        board_id: this.boardId,
                        search: this.search,
                        category_id: this.categoryId,
                        page: this.page
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        const res = response.data.data;
                        this.posts = res.data;
                        this.page = res.current_page;
                        this.lastPage = res.last_page;
                        this.total = res.total;
                    }).catch(error => {
                        console.error(error);
                        alert('게시글 목록을 불러오는데 실패했습니다.');
                    });
                },

                fetchCategories() {
                    axios.post('/api/admin/categories/list', {
                        board_id: this.boardId
                    }, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        this.categories = response.data.data;
                    }).catch(error => {
                        console.error(error);
                    });
                },

                addCategory() {
                    if (!this.newCategoryName.trim()) return;
                    axios.post('/api/admin/categories/store', {
                        board_id: this.boardId,
                        name: this.newCategoryName
                    }).then(response => {
                        this.newCategoryName = '';
                        this.fetchCategories();
                    }).catch(error => alert('카테고리 추가 실패'));
                },

                deleteCategory(id) {
                    if (confirm('정말로 삭제하시겠습니까? 관련된 게시글의 카테고리가 비워집니다.')) {
                        axios.post('/api/admin/categories/delete', { id: id })
                        .then(() => {
                            this.fetchCategories();
                            this.fetchPosts();
                        }).catch(error => alert('삭제 실패: ' + (error.response?.data?.message || '알 수 없는 오류')));
                    }
                },

                deletePost(id) {
                    if (confirm('정말로 이 게시글을 삭제하시겠습니까? 관련된 모든 데이터가 삭제됩니다.')) {
                        axios.post('/api/admin/posts/delete', {
                            id: id
                        }, {
                            headers: { 'Content-Type': 'application/json' }
                        }).then(response => {
                            alert('삭제되었습니다.');
                            this.fetchPosts();
                        }).catch(error => {
                            console.error(error);
                            alert('삭제에 실패했습니다.');
                        });
                    }
                }
            }));
        });
    </script>
</x-admin.layout>
