<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\DoServiceA;
use App\Services\DoServiceB;

class DoServiceTest extends TestCase
{
    /** @test */
    public function test_do_service_a()
    {
        $doServiceA = new DoServiceA();
        $user = new User($doServiceA);
        $result = $doServiceA->do($user);
        $this->assertEquals('DoServiceA', $result);
    }

    /** @test */
    public function test_do_service_b()
    {
        $doServiceB = new DoServiceB();
        $user = new User($doServiceB);
        $result = $doServiceB->do($user);
        $this->assertEquals('DoServiceB', $result);
    }
}