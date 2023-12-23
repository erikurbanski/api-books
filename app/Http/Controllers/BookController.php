<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Core\UseCase\Book\ListBooksUseCase;

class BookController extends Controller
{
    public function index(Request $request, ListBooksUseCase $useCase)
    {

    }
}
