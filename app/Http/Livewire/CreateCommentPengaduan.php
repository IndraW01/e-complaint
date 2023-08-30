<?php

namespace App\Http\Livewire;

use App\Models\Mahasiswa;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateCommentPengaduan extends Component
{
    public $pengaduanId;
    public $pesan;
    private Mahasiswa | User $userLogin;

    public function __construct()
    {
        $this->userLogin = Auth::user();
    }

    protected $rules = [
        'pesan' => 'required|max:200',
    ];

    public function mount($pengaduanId)
    {
        $this->pengaduanId = $pengaduanId;
    }

    public function save(Request $request)
    {

        if ($request->user()->cannot('update', Pengaduan::query()->firstWhere('id', $this->pengaduanId))) {
            return $this->emit('error', 'Gagal Menambah Komentar');
        }

        $this->validate();

        $this->userLogin->Comments()->create([
            'pengaduan_id' => $this->pengaduanId,
            'pesan' => $this->pesan,
        ]);

        $this->emit('renderCommentCount');
        $this->emit('renderComment');
        $this->emit('success', 'Berhasil Menambah Komentar');

        $this->reset('pesan');
    }

    public function render()
    {
        return view('livewire.create-comment-pengaduan');
    }
}
