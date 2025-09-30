<?php

namespace Tests\Unit;

use Orchestra\Testbench\TestCase;


class ActivityLoggerTest extends TestCase
{


    public function test_create_log(): void
    {
        $user = \App\Models\User::factory()->create()->fresh();

        $log = createActivityLog(
            made_by_model: $user,
            human_message: 'User created',
        );

        $this->assertDatabaseHas('activity_logs', [
            'id' => $log->id,
        ]);
    }


}
