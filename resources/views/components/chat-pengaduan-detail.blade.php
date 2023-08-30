@props(['comments'])

<ul class="list-inline p-0 m-0">
    @foreach ($comments as $comment)
        @if ($comment->commentable_type == 'App\Models\Mahasiswa')
            <x-chat-detail class="justify-content-start">
                <div class="ms-3">
                    <h6 class="mb-1">{{ $comment->commentable->name }}</h6>
                    <p class="mb-1">{!! $comment->pesan !!}</p>
                    <div class="d-flex flex-wrap align-items-center mb-1">
                        <form action="{{ route('pengaduan.comment.destroy', $comment) }}" class="me-3 comment-delete"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border-0 bg-white">
                                <span class="text-danger">
                                    <i class="fa-solid fa-trash fa-fw"></i>
                                    Delete
                                </span>
                            </button>
                        </form>
                        <span> {{ $comment->created_at->diffForHumans() }} </span>
                    </div>
                </div>
            </x-chat-detail>
        @else
            <x-chat-detail class="justify-content-end" order="order-2">
                <div class="me-3">
                    <h6 class="mb-1 text-end">{{ $comment->commentable->name }}</h6>
                    <p class="mb-1 text-end">{!! $comment->pesan !!}</p>
                    <div class="d-flex flex-wrap align-items-center mb-1 justify-content-end">
                        <form action="{{ route('pengaduan.comment.destroy', $comment) }}" class="me-3 comment-delete"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border-0 bg-white">
                                <span class="text-danger">
                                    <i class="fa-solid fa-trash fa-fw"></i>
                                    Delete
                                </span>
                            </button>
                        </form>
                        <span> {{ $comment->created_at->diffForHumans() }} </span>
                    </div>
                </div>
            </x-chat-detail>
        @endif
    @endforeach
</ul>
<form class="comment-text d-flex align-items-center mt-3" action="javascript:void(0);">
    <input type="text" class="form-control rounded" placeholder="Lovely!">
    <div class="comment-attagement d-flex">
        <a href="javascript:void(0);" class="me-2 text-body">
            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" />
            </svg>
        </a>
        <a href="javascript:void(0);" class="text-body">
            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                <path fill="currentColor"
                    d="M20,4H16.83L15,2H9L7.17,4H4A2,2 0 0,0 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6A2,2 0 0,0 20,4M20,18H4V6H8.05L9.88,4H14.12L15.95,6H20V18M12,7A5,5 0 0,0 7,12A5,5 0 0,0 12,17A5,5 0 0,0 17,12A5,5 0 0,0 12,7M12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15Z" />
            </svg>
        </a>
    </div>
</form>

@push('my-js')
    <script>
        const comments = document.querySelectorAll('.comment-delete');
        comments.forEach((comment) => {
            comment.addEventListener('submit', (e) => {
                e.preventDefault()
                Swal.fire({
                    title: `Apa kamu yakin ?`,
                    text: `Anda akan menghapus komentar!`,
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus itu!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                })
            });
        })
    </script>
@endpush
