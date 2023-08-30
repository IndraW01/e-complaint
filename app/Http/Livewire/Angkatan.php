<?php

namespace App\Http\Livewire;

use App\Models\Jurusan;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Angkatan extends Component
{
    public $selectedJurusan = null;
    public $angkatans = null;

    public function updateAngkatan()
    {
        $this->angkatans = range(2018, date('Y'));
    }

    public function render()
    {
        return view('livewire.angkatan', [
            'jurusans' => Jurusan::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }
}
