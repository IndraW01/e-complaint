<?php

namespace App\Http\Livewire;

use App\Models\Jurusan;
use Livewire\Component;
use Illuminate\Support\Str;

class SlugPretty extends Component
{
    public $jurusan;
    public $name;
    public $slug;

    public function mount($jurusan)
    {
        $this->jurusan = $jurusan;
        $this->name = request()->old('name') ?? $jurusan?->name;
        $this->slug = request()->old('slug') ?? $jurusan?->slug;
    }

    public function sluglable()
    {
        $slugGenerate = Str::slug($this->name);
        $slugExists = Jurusan::query()->where('slug', $slugGenerate)->exists();

        if ($this->jurusan) {
            $slug = $slugGenerate == $this->jurusan->slug ? $slugGenerate : ($slugExists ? $slugGenerate . '-' . rand(1, 99) : $slugGenerate);
        } else {
            $slug = $slugExists ? $this->slug = $slugGenerate . '-' . rand(1, 99) : $this->slug = $slugGenerate;
        }

        $this->slug = $slug;
    }

    public function render()
    {
        return view('livewire.slug-pretty');
    }
}
