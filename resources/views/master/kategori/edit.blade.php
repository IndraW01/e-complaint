<x-main-layout title="E-Complaint Kategori-Ubah">
    <div class="card m-auto col-8">
        <div class="card-header">
            <div class="header-title">
                <h4 class="card-title">Ubah Kategori</h4>
            </div>
        </div>
        <div class="card-body" x-data="sluglable()">
            <form action="{{ route('master.kategori.update', ['kategori' => $kategori]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label" for="name">Name</label>
                    <input @change="generateSlug" x-model="name" type="text"
                        class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $kategori->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="slug">Slug</label>
                    <input x-model='slug' type="text" class="form-control @error('slug') is-invalid @enderror"
                        id="slug" name="slug" value="{{ old('slug', $kategori->slug) }}" readonly>
                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-circle-plus fa-fw"></i>
                    Ubah</button>
                <a href="{{ route('master.kategori.index') }}" class="btn btn-secondary"><i
                        class="fa-solid fa-arrow-left fa-fw"></i>
                    Kembali</a>
            </form>
        </div>
    </div>

    @push('my-js')
        <script>
            const sluglable = () => {
                return {
                    name: "{{ $kategori->name }}",
                    slug: "{{ $kategori->slug }}",
                    async generateSlug() {
                        const {
                            slugJson
                        } = await fetch(`https://e-complaint.dev/master/kategori/slug`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                name: this.name,
                                slugEdit: "{{ $kategori->slug }}"
                            })
                        }).then(response => response.json());

                        this.slug = slugJson;
                    }
                }
            };
        </script>
    @endpush
</x-main-layout>
