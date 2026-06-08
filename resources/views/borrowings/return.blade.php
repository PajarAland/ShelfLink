<x-app-layout>
    <main class="py-8">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">

            <h1 class="text-2xl font-bold mb-6">
                Upload Bukti Kondisi Buku
            </h1>

            <div class="mb-6">
                <h2 class="font-semibold text-lg">
                    {{ $borrowing->book->title }}
                </h2>

                <p class="text-sm text-gray-500 mt-2">
                    Upload beberapa foto kondisi buku dari berbagai sisi untuk diverifikasi admin.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 p-4 mb-4 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('borrowings.return', $borrowing->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-6">

                    <label class="block font-medium mb-2">
                        Upload Foto Buku
                    </label>

                    <input type="file"
                           name="return_photos[]"
                           multiple
                           required
                           class="w-full border rounded-lg p-3">

                    <p class="text-sm text-gray-500 mt-2">
                        Upload minimal 1 foto:
                    </p>

                    <ul class="text-sm text-gray-500 list-disc ml-5 mt-1">
                        <li>Cover depan</li>
                        <li>Cover belakang</li>
                        <li>Sisi buku</li>
                        <li>Isi halaman</li>
                    </ul>

                </div>

                <button type="submit"
                        class="bg-indigo-600 text-white px-5 py-3 rounded-lg hover:bg-indigo-700">
                    Kirim Pengembalian
                </button>

            </form>

        </div>
    </main>
</x-app-layout>