<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response($books);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if($book == null)
        return response(['message' => 'Book not found'], 404);

        return response($book,200);
    }

    public function store(Request $request)
    {
        $book = request()->validate([
            'name' => 'required|min:3|max:45',
            'description' => 'max:255',
            'url' => 'url'
        ]);

        if ($request->hasFile('image')) {
            $book['image'] = $request->file('image')->store('books', 'public');
        } else {
            $book['image'] = 'storage/app/public/books/default.jpg';
        }

        $book = Book::create($book);

        return response($book,200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if($book == null)
            return response(['message' => 'Book not found'], 404);

          $credentials = $request->validate([
            'name' => 'string|max:45',
            'description' => 'string|max:255'
        ]);

        if ($request->hasFile('image')) {
            $credentials['image'] = $request->file('image')->store('books', 'public');
        }
        $book->update($credentials);
        return response($book,200);
    }

    public function delete($id)
    {
        $book = Book::find($id);
        
        if($book == null)
          return response(['message' => 'Book not found'], 404);

        $book->delete();

        return response(['message'=>'Book was deleted'],200);
    }
}
