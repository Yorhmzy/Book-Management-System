<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendEmailJob as SendEmail;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all books that belongs to the user
        $books = auth()->user()->books;
        return response(['books' => BookResource::collection($books)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // Validation
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255'
        ]);

        if($validator->fails()) {
            return response(['error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        }

        DB::beginTransaction();
        try {
            $book = Book::create($data);
            $user = auth()->user();
            $user->books()->save($book);
        } catch (\Throwable $e) {
            DB::rollback();
            return response(['message' => 'An error occured'], 500);
        }

        DB::commit();

        // Dispatch Job
        SendEmail::dispatch($book, auth()->user(), 'added');

        return response(['book' => new BookResource($book), 'message' => 'Added to the list successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return response(['book' => new BookResource($book), 'message' => 'Retrieved successfully']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->all();

        // Validation
        $validator = Validator::make($data, [
            'title' => 'string|max:255',
            'author' => 'string|max:255'
        ]);

        if($validator->fails()) {
            return response(['error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        }

        DB::beginTransaction();

        try {
            $book->update($data);
        } catch (\Throwable $e) {
            DB::rollback();
            return response(['message' => 'An error occured'], 500);
        }

        DB::commit();

        return response(['book' => new BookResource($book), 'message' => 'Updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Book $book)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'forceDelete' => 'required|boolean|max:255'
        ]);

        if($validator->fails()) {
            return response(['error' => $validator->errors(), 'message' => 'Validation Error'], 422);
        }

        DB::beginTransaction();

        try {
            if ($request->forceDelete) $book->forceDelete();
            else $book->delete();
        } catch (\Throwable $e) {
            DB::rollback();
            return response(['message' => 'An error occured'], 500);
        }

        DB::commit();

        // Dispatch Job
        SendEmail::dispatch($book, auth()->user(), 'deleted');

        return response(['message' => 'Deleted']);
    }
}
