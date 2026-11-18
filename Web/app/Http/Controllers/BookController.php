<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category', 'semua');
        $query = Book::regular();

        if ($category !== 'semua') {
            $query->where('kategori', $category);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%'.$request->input('search').'%');
        }

        $books = $query->orderByDesc('terjual')->get();
        $bundle = Book::bundle()->first();

        return view('member.kamus-bosowalikan', compact('books', 'bundle', 'category'));
    }
}
