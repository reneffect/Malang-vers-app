<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EbookController extends Controller
{
    public function index()
    {
        $ebooks = Ebook::latest()->paginate(10);

        return view('admin.ebooks', [
            'ebooks' => $ebooks,
            'totalKamus' => Ebook::where('sudah_diterbitkan', true)->count(),
            'totalUnduhan' => Ebook::sum('jumlah_unduhan'),
            'pendapatan' => Ebook::sum('harga'),
            'avgRating' => Ebook::avg('rating'),
            'jumlahUlasan' => Ebook::where('rating', '>', 0)->count(),
        ]);
    }

    public function store(Request $r)
    {
        $data = $this->validateData($r, true);

        $data['kode_url'] = Str::slug($r->judul);
        $data['file_pdf'] = $r->file('file_pdf')->store('ebooks', 'public');

        Ebook::create($data);

        return back()->with('success', 'Kamus berhasil dipublikasikan!');
    }

    public function update(Request $r, Ebook $ebook)
    {
        $data = $this->validateData($r, false);

        if ($r->hasFile('file_pdf')) {
            if ($ebook->file_pdf) {
                Storage::disk('public')->delete($ebook->file_pdf);
            }
            $data['file_pdf'] = $r->file('file_pdf')->store('ebooks', 'public');
        }

        $ebook->update($data);

        return back()->with('success', 'Kamus berhasil diperbarui!');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->file_pdf) {
            Storage::disk('public')->delete($ebook->file_pdf);
        }
        $ebook->delete();

        return back()->with('success', 'Kamus dihapus dari inventaris.');
    }

    private function validateData(Request $r, bool $isCreate)
    {
        return $r->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|in:Saku,Akbar,Digital,Cetak,Anak,Akademis',
            'deskripsi' => 'required|string|max:2000',
            'harga' => 'required|numeric|min:0',
            'file_pdf' => ($isCreate ? 'required' : 'nullable').'|file|mimes:pdf|max:102400',
        ], [
            'file_pdf.mimes' => 'Berkas harus berformat PDF.',
            'file_pdf.max' => 'Ukuran PDF maksimal 100MB.',
        ]);
    }
}
