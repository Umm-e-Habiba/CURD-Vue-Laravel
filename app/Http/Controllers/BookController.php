<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Book;
use App\Models\Books;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;


class BookController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'launch' => 'required|numeric',
        ]);

        $book = Books::create($validated);
        if ($request->wantsJson()) {
            return response()->json(['book' => $book, 'success' => 'Book created successfully!']);
        }
        // Redirect or return a response
        return Redirect::route('book')->with('success', 'Book created successfully!');
    }

    public function index()
    {
        $books = Books::all(); // Fetch all books
    return Inertia::render('Book', ['books' => $books]);
       
    
    }

    public function destroy($id)
    {
        $book = Books::findOrFail($id);
        $book->delete();
    
        //return response()->json(['message' => 'Book deleted successfully!']);
        return Redirect::route('book')->with('Deleted', 'Book deleted successfully!');
    }

    public function edit($id)
    {
        $book = Books::findOrFail($id);
        return Inertia::render('EditBook', ['book' => $book]);
    }

    // Update the specified book
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'launch' => 'required|numeric',
        ]);

        $book = Books::findOrFail($id);
        $book->update($validated);

        if ($request->wantsJson()) {
            return response()->json(['book' => $book, 'success' => 'Book updated successfully!']);
        }
        
        return Redirect::route('book')->with('success', 'Book updated successfully!');
    }

    
    
}