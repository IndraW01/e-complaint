<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class PengaduanCount extends Component
{
    public $pengaduanId;

    protected $listeners = ['renderCommentCount' => 'render'];

    public function mount($pengaduanId)
    {
        $this->pengaduanId = $pengaduanId;
    }

    public function render()
    {
        return view('livewire.pengaduan-count', [
            'commentCount' => Comment::query()->where('pengaduan_id', $this->pengaduanId)->count()
        ]);
    }
}
