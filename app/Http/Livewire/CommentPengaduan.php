<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Livewire\Component;

class CommentPengaduan extends Component
{
    use AuthorizesRequests;

    public $pengaduanId;

    protected $listeners = ['renderComment' => 'render'];

    public function  mount($pengaduanId)
    {
        $this->pengaduanId = $pengaduanId;
    }

    public function deleteComment(Request $request, Comment $comment)
    {
        if ($request->user()->cannot('delete', $comment)) {
            return $this->emit('error', 'Gagal Menghapus Komentar');
        }

        $comment->delete();

        $this->emit('renderCommentCount');
        $this->emit('success', 'Berhasil Menghapus Komentar');
    }

    public function render()
    {
        return view('livewire.comment-pengaduan', [
            'comments' => Comment::query()->with('commentable')->where('pengaduan_id', $this->pengaduanId)->get(),
        ]);
    }
}
