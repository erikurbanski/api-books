<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use Symfony\Component\HttpFoundation\Response;

class BookApiTest extends TestCase
{
    protected string $endpoint = '/api/books';

    /**
     * Test list empty books.
     * @return void
     */
    public function testListEmptyBooks()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);

        $response->assertJsonCount(0, 'data');
    }

    /**
     * Test paginate books.
     * @return void
     */
    public function testPaginateBooks()
    {
        Book::factory()->count(30)->create();

        $response = $this->getJson("$this->endpoint?page=2");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'meta' => [
                'total',
                'last_page',
                'first_page',
                'per_page',
                'to',
                'from'
            ],
        ]);

        $this->assertEquals(2, $response['meta']['current_page']);
        $this->assertEquals(30, $response['meta']['total']);

        $response->assertJsonCount(15, 'data');
    }

    /**
     * Test get data book.
     * @return void
     */
    public function testGetBook()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("$this->endpoint/$book->id");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'edition',
                'year',
                'value',
                'publisher'
            ],
        ]);

        $this->assertEquals($book->id, $response['data']['id']);
    }

    /**
     * Test create new book.
     * @return void
     */
    public function testCreateBook()
    {
        $authors = Author::factory()->count(3)->create();
        $authorsId = $authors->pluck('id')->toArray();

        $subjects = Subject::factory()->count(1)->create();
        $subjectsId = $subjects->pluck('id')->toArray();

        $data = [
            'title' => 'History of Brazil',
            'edition' => 2,
            'year' => '1988',
            'publisher' => 'Atlas',
            'value' => 150,
            'authors' => $authorsId,
            'subjects' => $subjectsId,
        ];

        $response = $this->postJson($this->endpoint, $data);
        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'edition',
                'year',
                'value',
                'publisher',
            ]
        ]);

        $this->assertEquals($data['title'], $response['data']['title']);
        $this->assertDatabaseHas('book', [
            'id' => $response['data']['id'],
            'title' => $response['data']['title'],
        ]);
    }

    /**
     * Test create validations book.
     * @return void
     */
    public function testCreateValidationsAuthor()
    {
        $authors = Author::factory()->count(3)->create();
        $authorsId = $authors->pluck('id')->toArray();

        $data = [
            'title' => 'History of Brazil',
            'edition' => 2,
            'year' => '1988',
            'publisher' => 'Atlas',
            'value' => 150,
            'authors' => $authorsId,
        ];

        $response = $this->postJson($this->endpoint, $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'subjects',
            ],
        ]);
    }

    /**
     * Test delete book not found.
     * @return void
     */
    public function testDeleteBookNotFound()
    {
        $response = $this->deleteJson("$this->endpoint/12");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test delete book.
     * @return void
     */
    public function testDeleteBook()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("$this->endpoint/$book->id");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
