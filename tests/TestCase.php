<?php

namespace Tests;

use Bouncer;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DetectRepeatedQueries;

    public function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('assertViewCollection', function ($var) {
            return new TestCollectionData($this->viewData($var));
        });

        $this->enableQueryLog();
    }

    public function tearDown(): void
    {
        $this->flushQueryLog();

        parent::tearDown();
    }

    protected function createUser(array $attributes = [])
    {
        return factory(User::class)->create($attributes);
    }

    protected function createAdmin()
    {
        $user = factory(User::class)->create();

        $user->allow()->everything();

        return $user;
    }

    protected function assertDatabaseEmpty($table, $connection = null)
    {
        $total = $this->getConnection($connection)->table($table)->count();

        $this->assertSame(
            0, $total,
            sprintf("Failed asserting the table [%s] is empty. %s %s found.", $table, $total, Str::plural('row', $total))
        );
    }
}
