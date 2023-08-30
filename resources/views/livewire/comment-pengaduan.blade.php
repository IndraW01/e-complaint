<div>
    @if (count($comments) > 0)
        <ul class="list-inline p-0 m-0">
            @foreach ($comments as $comment)
                @if ($comment->commentable_type == 'App\Models\Mahasiswa')
                    <x-chat-detail class="justify-content-start">
                        <div class="ms-3">
                            @if (\Auth::guard('mahasiswa')->id() == $comment->commentable_id || \Auth::guard('web')->check())
                                <h6 class="mb-1">{{ $comment->commentable->name }}</h6>
                            @else
                                <h6 class="mb-1">{{ \Str::mask($comment->commentable->nim, '*', 5) }}</h6>
                            @endif
                            <p class="mb-1">{!! $comment->pesan !!}</p>
                            <div class="d-flex flex-wrap align-items-center mb-1">
                                <span wire:poll.60000ms.keep-alive> {{ $comment->created_at->diffForHumans() }} </span>
                                @can('delete', $comment)
                                    <a href="#" class="ms-3 comment-delete"
                                        wire:click.prevent="deleteComment('{{ $comment->id }}')">
                                        <span class="text-danger">
                                            <i class="fa-solid fa-trash fa-fw"></i>
                                            Delete
                                        </span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </x-chat-detail>
                @else
                    <x-chat-detail class="justify-content-end" order="order-2">
                        <div class="me-3">
                            <h6 class="mb-1 text-end">{{ $comment->commentable->name }}</h6>
                            <p class="mb-1 text-end">{!! $comment->pesan !!}</p>
                            <div class="d-flex flex-wrap align-items-center mb-1 justify-content-end">
                                @can('delete', $comment)
                                    <a href="#" class="me-3 comment-delete"
                                        wire:click.prevent="deleteComment('{{ $comment->id }}')">
                                        <span class="text-danger">
                                            <i class="fa-solid fa-trash fa-fw"></i>
                                            Delete
                                        </span>
                                    </a>
                                @endcan
                                <span wire:poll.60000ms.keep-alive> {{ $comment->created_at->diffForHumans() }} </span>
                            </div>
                        </div>
                    </x-chat-detail>
                @endif
            @endforeach
        </ul>
    @else
        <div class="mb-2 text-center">
            Komentar Kosong
        </div>
    @endif
</div>
