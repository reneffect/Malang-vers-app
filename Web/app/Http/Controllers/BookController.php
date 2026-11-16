<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'semua');

        // Query buku (menggunakan scope regular yang sudah kita buat di Model)
        $query = Book::regular();

        if ($category !== 'semua') {
            $query->where('kategori', $category); // Ubah 'category' jadi 'kategori'
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where('judul', 'like', '%'.$request->search.'%'); // Ubah 'title' jadi 'judul'
        }

        // Ubah 'sold' jadi 'terjual'
        $books = $query->orderBy('terjual', 'desc')->get();

        // Ambil data bundle untuk banner bawah
        $bundle = Book::bundle()->first();

        return view('member.kamus-bosowalikan', compact('books', 'bundle', 'category'));
    }
}
