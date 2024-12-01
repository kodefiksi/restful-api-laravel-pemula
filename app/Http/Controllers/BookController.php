<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

// model
use App\Models\Book;

class BookController extends Controller
{
    // list buku
    public function index() {
        $books = Book::all();
        return response()->json([
            'status' => 'success',
            'data' => [
                'books' => $books
            ]
        ], 200);
    }

    // mengambil satu buku berdasarkan id
    public function show($id) {
        $book = Book::find($id);

        if ($book) {
            return response()->json([
                'status' => 'success',
                'data' => $book
            ], 200);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'Buku tidak ditemukan'
        ], 404);
    }

    // menambahkan buku
    public function store(Request $request) {
        // validasi input
        $validated = Validator::make($request->all(), [
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error Validasi',
                'data' => $validated->errors()
            ], 422);
        }

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Buku berhasil ditambahkan'
        ], 201);
    }

    // mengubah buku
    public function update(Request $request, $id) {
        $book = Book::find($id);

        if ($book) {
            // validasi input
            $validated = Validator::make($request->all(), [
                'title' => 'required|string',
                'author' => 'required|string',
                'description' => 'required|string'
            ]);

            if ($validated->fails()) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Error Validasi',
                    'data' => $validated->errors()
                ], 422);
            }

            $book->update([
                'title' => $request->title,
                'author' => $request->author,
                'description' => $request->description
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Buku berhasil diperbarui'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Buku tidak ditemukan'
        ], 404);
    }

    // menghapus buku
    public function destroy($id) {
        $book = Book::find($id);

        if ($book) {
            $book->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Buku berhasil dihapus'
            ], 200);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'Buku tidak ditemukan'
        ], 404);
    }
}
