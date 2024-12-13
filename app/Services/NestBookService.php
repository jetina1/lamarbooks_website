<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NestBookService
{
    protected $baseUri;

    public function __construct()
    {
        // Set the base URI for your NestJS backend API
        $this->baseUri = config('services.nestjs.base_uri'); // Configure this in .env file
    }

    /**
     * Get all books.
     */
    public function getAllBooks()
    {
        return Http::get("{$this->baseUri}/books")->json();
    }

    /**
     * Create a new book.
     * 
     * @param array $data
     */
    public function createBook(array $data)
    {
        return Http::post("{$this->baseUri}/books", $data)->json();
    }

    /**
     * Update an existing book by ID.
     * 
     * @param int $id
     * @param array $data
     */
    public function updateBook(int $id, array $data)
    {
        return Http::put("{$this->baseUri}/books/{$id}", $data)->json();
    }

    /**
     * Delete a book by ID.
     * 
     * @param int $id
     */
    public function deleteBook(int $id)
    {
        return Http::delete("{$this->baseUri}/books/{$id}")->json();
    }
}
