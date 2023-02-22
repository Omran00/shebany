<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Favorite_book;
use App\Models\Student;

class Favorite_bookController extends Controller
{
    // return all students that have selected this book as a favorite book
    public function show_students($book_id)
    {
        $students_ids = Favorite_book::where('book_id', $book_id)->get()->toArray();
        $students = Student::whereIn('id', $students_ids)->get();

        return response($students,200);
    }

    // return all books that have selected from student
    public function show_books($student_id)
    {
        $books_ids = Favorite_book::where('student_id', $student_id)->get();
        $books = Book::whereIn('id', $books_ids)->get();
        return response($books,200);
    }

    public function store($book_id, $student_id)
    {
        $student = Student::where('id', $student_id)->first();

        if(auth()->user()->id != $student['father_id'])
        return response(['message'=>'You are not allowed to add this book for favorite.'], 403);

        $book = Book::where('id', $book_id)->first();

        $book->students()->syncWithoutDetaching($student_id, ['book_id' => $book_id]);

        return response([
            'book' => $book,
            'student' => $student], 200);
    }

    public function delete($book_id, $student_id)
    {
        $student = Student::where('id', $student_id)->first();

        if(auth()->user()->id != $student['father_id'])
            return response(['message'=>'You are not allowed to remove this book from favorite.'], 403);

        $favorite_book = Favorite_book::where([
            ['book_id', $book_id],
            ['student_id', $student_id],
        ])->first();
        $favorite_book?->delete();

        return response([
            'message' => 'book was removed from my favorite'], 200);
    }
}
