<x-admin.layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('admin.posts.index', ['slug' => $board->slug]) }}" class="text-gray-500 hover:text-gray-700 mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            @if(isset($post))
                [{{ $board->name }}] 게시글 수정
            @else
                [{{ $board->name }}] 새 게시글 작성
            @endif
        </div>
    </x-slot>

    <!-- Load CDN for CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <div class="max-w-5xl" x-data="postForm()">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8">
                <form @submit.prevent="savePost" class="space-y-6">

                    <!-- Category Selection -->
                    <div x-show="categories.length > 0">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">카테고리 <span class="text-rose-500">*</span></label>
                        <select id="category_id" x-model="form.category_id" class="mt-1 block w-full pl-3 pr-10 py-2 border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" :required="categories.length > 0">
                            <option value="" disabled>카테고리를 선택하세요</option>
                            <template x-for="cat in categories" :key="cat.id">
                                <option :value="cat.id" x-text="cat.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">제목 <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" x-model="form.title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required placeholder="게시글 제목을 입력하세요">
                    </div>

                    @if($board->type === 'album')
                    <!-- Thumbnail for Album Board -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">대표 썸네일 <span class="text-rose-500">*</span></label>
                        <div class="mt-2 flex items-center space-x-4">
                            <div class="flex-shrink-0 h-32 w-48 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden bg-gray-50 relative">
                                <template x-if="form.thumbnail">
                                    <img :src="form.thumbnail" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!form.thumbnail">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="mt-1 pl-1 text-xs text-gray-500 block">이미지 선택</span>
                                    </div>
                                </template>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                                    <span>썸네일 업로드</span>
                                    <input type="file" class="sr-only" @change="uploadThumbnail" accept="image/*">
                                </label>
                                <button type="button" @click="form.thumbnail = null" x-show="form.thumbnail" class="text-xs text-rose-500 hover:text-rose-700">썸네일 삭제</button>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($board->type === 'youtube')
                    <!-- Youtube URL -->
                    <div>
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700">유튜브 링크 <span class="text-rose-500">*</span></label>
                        <div class="mt-1 text-sm text-gray-500">유튜브 영상 주소 (예: https://www.youtube.com/watch?v=...)를 입력해주세요.</div>
                        <div class="flex mt-2 space-x-2">
                            <input type="url" id="youtube_url" x-model="form.youtube_url" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required placeholder="https://www.youtube.com/watch?v=...">
                            <button type="button" @click="fetchYoutubeInfo" :disabled="fetchingYoutube" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 flex-shrink-0">
                                <span x-show="!fetchingYoutube">영상 정보 불러오기</span>
                                <span x-show="fetchingYoutube">불러오는 중...</span>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">대표 썸네일 <span class="text-rose-500">*</span></label>
                        <div class="mt-2 flex items-center space-x-4">
                            <div class="flex-shrink-0 h-32 w-48 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden bg-gray-50 relative">
                                <template x-if="form.thumbnail">
                                    <img :src="form.thumbnail" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!form.thumbnail">
                                    <div class="text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="mt-1 pl-1 text-xs text-gray-500 block">이미지 선택</span>
                                    </div>
                                </template>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <label class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-center">
                                    <span>썸네일 업로드</span>
                                    <input type="file" class="sr-only" @change="uploadThumbnail" accept="image/*">
                                </label>
                                <button type="button" @click="form.thumbnail = null" x-show="form.thumbnail" class="text-xs text-rose-500 hover:text-rose-700">썸네일 삭제</button>
                            </div>
                        </div>
                    </div>
                    <!-- Tag -->
                    <div>
                        <label for="youtube_tag" class="block text-sm font-medium text-gray-700">태그</label>
                        <input type="text" id="youtube_tag" x-model="form.youtube_tag" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="동영상 태그을 입력하세요">
                    </div>
                    @endif

                    @if($board->type !== 'youtube')
                    <!-- Content (CKEditor 5) -->
                    <div>
                        <label for="editor" class="block text-sm font-medium text-gray-700 mb-2">본문 내용 <span class="text-rose-500">*</span></label>
                        <div class="border border-gray-300 rounded-md shadow-sm overflow-hidden prose max-w-none">
                            <textarea id="editor" name="content"></textarea>
                        </div>
                    </div>
                    @else
                    <!-- Hidden Content for Youtube (storing meta description) -->
                    <input type="hidden" name="content" x-model="form.content">
                    @endif

                    <!-- Form Actions -->
                    <div class="pt-5 border-t border-gray-200 mt-8 flex justify-end space-x-3">
                        <a href="{{ route('admin.posts.index', ['slug' => $board->slug]) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            취소
                        </a>
                        <button type="submit" :disabled="saving" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                            <span x-show="!saving">저장하기</span>
                            <span x-show="saving">저장 중...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
        .ck-content img {
            max-width: 100%;
            height: auto;
        }
    </style>

    <script>
        // Custom Upload Adapter for CKEditor 5
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('file', file);
                    data.append('folder', 'board/{{ $board->id }}');

                    axios.post('/api/admin/upload', data, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        resolve({
                            default: response.data.url
                        });
                    }).catch(error => {
                        reject(error.response ? error.response.data.message : 'Upload failed');
                    });
                }));
            }

            abort() {
                // Handle abort if needed
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('postForm', () => ({
                isEdit: {{ isset($post) ? 'true' : 'false' }},
                postId: {{ isset($post) ? $post->id : 'null' }},
                boardId: {{ $board->id }},
                categories: [],
                saving: false,
                fetchingYoutube: false,
                editorInstance: null,

                form: {
                    board_id: {{ $board->id }},
                    category_id: {!! isset($post) && $post->category_id ? $post->category_id : '""' !!},
                    title: {!! isset($post) ? json_encode($post->title) : '""' !!},
                    content: {!! isset($post) ? json_encode($post->content) : '""' !!},
                    thumbnail: {!! isset($post) && $post->thumbnail ? json_encode($post->thumbnail) : 'null' !!},
                    attachments: {!! isset($post) && $post->attachments ? json_encode($post->attachments) : '[]' !!},
                    youtube_url: {!! isset($post) && $post->attachments && is_array($post->attachments) && isset($post->attachments['youtube_url']) ? json_encode($post->attachments['youtube_url']) : '""' !!},
                    youtube_tag: {!! isset($post) && $post->attachments && is_array($post->attachments) && isset($post->attachments['youtube_tag']) ? json_encode($post->attachments['youtube_tag']) : '""' !!}
                },

                init() {
                    this.fetchCategories();

                    // Initialize CKEditor
                    if (document.querySelector('#editor')) {
                        ClassicEditor
                            .create(document.querySelector('#editor'), {
                                extraPlugins: [MyCustomUploadAdapterPlugin],
                            })
                            .then(editor => {
                                this.editorInstance = editor;
                                if (this.form.content) {
                                    editor.setData(this.form.content);
                                }
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                },

                fetchCategories() {
                    axios.post('/api/admin/categories/list', {
                        board_id: this.boardId
                    }).then(response => {
                        this.categories = response.data.data;
                        if (this.categories.length > 0 && !this.form.category_id && !this.isEdit) {
                            // Optionally set default category
                            // this.form.category_id = this.categories[0].id;
                        }
                    }).catch(error => console.error(error));
                },

                uploadThumbnail(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('folder', 'board/{{ $board->id }}');

                    axios.post('/api/admin/upload', formData, {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(response => {
                        this.form.thumbnail = response.data.url;
                    }).catch(error => {
                        alert('이미지 업로드에 실패했습니다.');
                        console.error(error);
                    });
                },

                fetchYoutubeInfo() {
                    const url = this.form.youtube_url;
                    if (!url) {
                        alert('유튜브 링크를 먼저 입력해주세요.');
                        return;
                    }

                    this.fetchingYoutube = true;
                    axios.post('/api/admin/youtube/fetch', {
                        url: url,
                        board_id: this.boardId
                    }).then(response => {
                        if (response.data.success) {
                            const data = response.data.data;
                            if (data.title && !this.form.title) {
                                this.form.title = data.title;
                            } else if (data.title) {
                                if (confirm('영상 제목으로 게시글 제목을 덮어쓰시겠습니까?')) {
                                    this.form.title = data.title;
                                }
                            }
                            if (data.thumbnail) {
                                this.form.thumbnail = data.thumbnail;
                            }
                            if (data.tags) {
                                this.form.youtube_tag = data.tags;
                            }
                            if (data.content) {
                                this.form.content = data.content;
                            }
                        }
                    }).catch(error => {
                        alert(error.response?.data?.message || '유튜브 정보를 불러오는 데 실패했습니다.');
                        console.error(error);
                    }).finally(() => {
                        this.fetchingYoutube = false;
                    });
                },

                savePost() {
                    if (this.categories.length > 0 && !this.form.category_id) {
                        alert('카테고리를 선택해주세요.');
                        return;
                    }

                    if (this.editorInstance) {
                        this.form.content = this.editorInstance.getData();
                    }

                    if (!this.form.title.trim()) {
                        alert('제목을 입력해주세요.');
                        return;
                    }

                    @if($board->type !== 'youtube')
                    if (!this.form.content || !this.form.content.trim()) {
                        alert('내용을 입력해주세요.');
                        return;
                    }
                    @endif

                    @if($board->type === 'album')
                    if (!this.form.thumbnail) {
                        alert('앨범형 게시판은 썸네일 등록이 필수입니다.');
                        return;
                    }
                    @endif

                    @if($board->type === 'youtube')
                    if (!this.form.youtube_url.trim()) {
                        alert('유튜브 링크를 입력해주세요.');
                        return;
                    }
                    if (Array.isArray(this.form.attachments)) {
                        this.form.attachments = {};
                    }
                    this.form.attachments.youtube_url = this.form.youtube_url;
                    this.form.attachments.youtube_tag = this.form.youtube_tag;
                    @endif

                    this.saving = true;

                    const url = this.isEdit ? '/api/admin/posts/update' : '/api/admin/posts/store';
                    const payload = { ...this.form };

                    if (this.isEdit) {
                        payload.id = this.postId;
                    }

                    axios.post(url, payload, {
                        headers: { 'Content-Type': 'application/json' }
                    }).then(response => {
                        alert('저장되었습니다.');
                        window.location.href = "{{ route('admin.posts.index', ['slug' => $board->slug]) }}";
                    }).catch(error => {
                        console.error(error);
                        alert(error.response?.data?.message || '저장 중 오류가 발생했습니다.');
                    }).finally(() => {
                        this.saving = false;
                    });
                }
            }));
        });
    </script>
</x-admin.layout>
