<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Author;
use Symfony\Component\HttpFoundation\Response;

class AuthorApiTest extends TestCase
{
    protected string $endpoint = '/api/authors';

    /**
     * Test list empty authors.
     * @return void
     */
    public function testListEmptyAuthors()
    {
        $response = $this->getJson($this->endpoint);
        $response->assertStatus(200);

        $response->assertJsonCount(0, 'data');
    }

    /**
     * Test paginate authors.
     * @return void
     */
    public function testPaginateAuthors()
    {
        Author::factory()->count(30)->create();

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
     * Test get author not found.
     * @return void
     */
    public function testGetAuthorNotFound()
    {
        $response = $this->getJson("$this->endpoint/1");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test get author.
     * @return void
     */
    public function testGetAuthor()
    {
        $author = Author::factory()->create();

        $response = $this->getJson("$this->endpoint/$author->id");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ],
        ]);

        $this->assertEquals($author->id, $response['data']['id']);
    }

    /**
     * Test create new author with exception.
     * @return void
     */
    public function testCreateAuthorException()
    {
        $data = [];
        $response = $this->postJson($this->endpoint, $data);

        $response->dump();
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ]
        ]);
    }

    /**
     * Test create new author.
     * @return void
     */
    public function testCreateAuthor()
    {
        $data = ['name' => 'Erik Urbanski'];
        $response = $this->postJson($this->endpoint, $data);

        $response->dump();
        $response->assertStatus(Response::HTTP_CREATED);

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ]
        ]);

        $this->assertEquals($data['name'], $response['data']['name']);
        $this->assertDatabaseHas('author', [
            'id' => $response['data']['id'],
            'name' => $response['data']['name'],
        ]);
    }

    /**
     * Test update author not found.
     * @return void
     */
    public function testUpdateAuthorNotFound()
    {
        $dataUpdated = ['name' => 'Erik Urbanski'];
        $response = $this->putJson("$this->endpoint/12", $dataUpdated);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test update validations author.
     * @return void
     */
    public function testUpdateValidationsAuthor()
    {
        $dataUpdated = [];
        $response = $this->putJson("$this->endpoint/12", $dataUpdated);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
            ],
        ]);
    }

    /**
     * Test update author.
     * @return void
     */
    public function testUpdateAuthor()
    {
        $author = Author::factory()->create();

        $dataUpdated = ['name' => 'Erik Urbanski'];
        $response = $this->putJson("$this->endpoint/$author->id", $dataUpdated);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
            ]
        ]);

        $this->assertEquals($dataUpdated['name'], $response['data']['name']);
        $this->assertDatabaseHas('author', [
            'id' => $response['data']['id'],
            'name' => $response['data']['name'],
        ]);
    }

    /**
     * Test delete author not found.
     * @return void
     */
    public function testDeleteAuthorNotFound()
    {
        $response = $this->deleteJson("$this->endpoint/12");

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * Test delete author.
     * @return void
     */
    public function testDeleteAuthor()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("$this->endpoint/$author->id");

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
