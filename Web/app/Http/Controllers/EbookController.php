<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EbookController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->string('category', 'semua')->toString();
        $search = trim($request->string('search')->toString());

        $books = Ebook::regular()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('judul', 'like', '%'.$search.'%')
                        ->orWhere('penulis', 'like', '%'.$search.'%');
                });
            })
            ->when(in_array($category, ['pemula', 'lengkap'], true), function ($query) use ($category): void {
                $query->whereRaw('LOWER(kategori) = ?', [$category]);
            })
            ->latest()
            ->get();

        $bundle = Ebook::bundle()->latest()->first();

        return view('member.kamus-bosowalikan', [
            'category' => $category,
            'books' => $books,
            'bundle' => $bundle,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);

        $baseKodeUrl = Str::slug($data['judul']);
        $kodeUrl = $baseKodeUrl;
        $suffix = 2;

        while (Ebook::where('kode_url', $kodeUrl)->exists()) {
            $kodeUrl = $baseKodeUrl.'-'.$suffix;
            $suffix++;
        }

        $data['kode_url'] = $kodeUrl;
        $data['lokasi_berkas'] = $request->file('file_pdf')->store('ebooks', 'public');
        $data['sudah_diterbitkan'] = true;
        unset($data['deskripsi'], $data['file_pdf']);

        Ebook::create($data);

        return back()->with('success', 'Kamus berhasil dipublikasikan!');
    }

    public function update(Request $request, Ebook $ebook)
    {
        $data = $this->validateData($request, false);

        if ($request->hasFile('file_pdf')) {
            if ($ebook->lokasi_berkas) {
                Storage::disk('public')->delete($ebook->lokasi_berkas);
            }
            $data['lokasi_berkas'] = $request->file('file_pdf')->store('ebooks', 'public');
        }

        if ($ebook->judul !== $data['judul']) {
            $baseKodeUrl = Str::slug($data['judul']);
            $kodeUrl = $baseKodeUrl;
            $suffix = 2;

            while (Ebook::where('kode_url', $kodeUrl)->whereKeyNot($ebook->getKey())->exists()) {
                $kodeUrl = $baseKodeUrl.'-'.$suffix;
                $suffix++;
            }

            $data['kode_url'] = $kodeUrl;
        }

        unset($data['deskripsi'], $data['file_pdf']);
        $ebook->update($data);

        return back()->with('success', 'Kamus berhasil diperbarui!');
    }

    public function destroy(Ebook $ebook)
    {
        if ($ebook->lokasi_berkas) {
            Storage::disk('public')->delete($ebook->lokasi_berkas);
        }
        $ebook->delete();

        return back()->with('success', 'Kamus dihapus dari inventaris.');
    }

    private function validateData(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|in:Saku,Akbar,Digital,Cetak,Anak,Akademis',
            'deskripsi' => 'required|string|max:2000',
            'harga' => 'required|numeric|min:0',
            'file_pdf' => ($isCreate ? 'required' : 'nullable').'|file|mimes:pdf|max:153600',
        ], [
            'file_pdf.mimes' => 'Berkas harus berformat PDF.',
            'file_pdf.max' => 'Ukuran PDF maksimal 150MB.',
        ]);
    }
}
