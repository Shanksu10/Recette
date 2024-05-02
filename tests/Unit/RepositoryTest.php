<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Repositories\Data;
use App\Repositories\Repository;

class RepositoryTest extends TestCase
{
    private $data;
    private $repository;

    public function setUp(): void
    {
        parent::setUp();
        $this->data = new Data();
        $this->repository = new Repository();
    }

    function testAgeOfUser(): void
    {
        $users = $this->data->users();
        $this->assertEquals($this->repository->ageOfUser($users[0]['id']), 24);
    }
}
