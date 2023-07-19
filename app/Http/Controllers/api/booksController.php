<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class booksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Books::paginate(10);
        return response([
            'current_page' => $books->currentPage(),
            'data' => $books->items(),
            'first_page_url' => $books->url(1),
            'from' => $books->firstItem(),
            'last_page' => $books->lastPage(),
            'last_page_url' => $books->url($books->lastPage()),
            'next_page_url' => $books->nextPageUrl(),
            'path' => $books->path(),
            'per_page' => $books->perPage(),
            'prev_page_url' => $books->previousPageUrl(),
            'to' => $books->lastItem(),
            'total' => $books->total()
        ]);
        // return Books::paginate(10);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'isbn' => 'required',
                'title' => 'required',
                'subtitle' => 'required',
                'author' => 'required',
                'published' => 'required',
                'publisher' => 'required',
                'pages' => 'required',
                'description' => 'required',
                'website' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => "Request Error",
                'user' => $validator->errors() //untuk menampilka pesan error di parameter tertentu
            ], 422);
        }

        $books = Books::create([
            'user_id' => $request->input("user_id"),
            'isbn' => $request->input('isbn'),
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'author' => $request->input('author'),
            'published' => $request->input('published'),
            'publisher' => $request->input('publisher'),
            'pages' => $request->input('pages'),
            'description' => $request->input('description'),
            'website' => $request->input('website'),
        ]);

        return response()->json([
            'messages' => "Book Created",
            'book' => $books
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Books::find($id);

        return response()->json([
            'id' => $book->id,
            'user_id' => $book->user_id,
            'isbn' => $book->isbn,
            'title' => $book->title,
            'subtitle' => $book->subtitle,
            'author' => $book->author,
            'published' => $book->published,
            'publisher' => $book->publisher,
            'pages' => $book->pages,
            'description' => $book->description,
            'website' => $book->website,
            'created_at' => $book->created_at,
            'updated_at' => $book->updated_at
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'isbn' => 'required',
                'title' => 'required',
                'subtitle' => 'required',
                'author' => 'required',
                'published' => 'required',
                'publisher' => 'required',
                'pages' => 'required',
                'description' => 'required',
                'website' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => "Request Error",
                'user' => $validator->errors() //untuk menampilka pesan error di parameter tertentu
            ], 422);
        }

        $book = Books::find($id);
        $book->update([
            'isbn' => $request->input('isbn'),
            'title' => $request->input('title'),
            'subtitle' => $request->input('subtitle'),
            'author' => $request->input('author'),
            'published' => $request->input('published'),
            'publisher' => $request->input('publisher'),
            'pages' => $request->input('pages'),
            'description' => $request->input('description'),
            'website' => $request->input('website'),
        ]);

        return response()->json([
            'message' => "Book Update",
            'book' => $book
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Books::find($id);
        $book = Books::find($id)->delete();
        return response()->json([
            'message' => 'Book Delete',
            'book' => $data
        ], 200);
    }
}
