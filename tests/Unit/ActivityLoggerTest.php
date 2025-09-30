<?php

namespace Tests\Unit;

use Orchestra\Testbench\TestCase;


class ActivityLoggerTest extends TestCase
{
    public function test_example_activity_log(): void
    {
        $this->assertTrue(true);
    }
     public function test_activity_fail_when_only_chain_create_method(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('At least one or more fields (humanMessage, humanExtraMessage, developerMessage, developerExtraMessage, applicationExtraMessage) must be set before calling create().');

        activity()->create();

    }
//to test this move this to your test folder

    // public function test_create_log(): void
    // {
    //     $user = User::factory()->create()->fresh();

    //     $log = createActivityLog(
    //         made_by_model: $user,
    //         human_message: 'User created via factory',
    //         developer_message: 'POST /register',
    //         developer_extra_message: ['ip' => request()->ip()],
    //         application_extra_message: ['debug' => 'custom app info']
    //     );

    //     $this->assertDatabaseHas('activity_logs', [
    //         'id' => $log->id,
    //     ]);
    // }
    // public function test_create_log_with_activity_helper(): void
    // {
    //     $user = User::factory()->create()->fresh();

    //     $log = activity()
    //         ->madeByModel($user)
    //         ->humanMessage('User registered')
    //         ->humanExtraMessage(['email' => $user->email])
    //         ->developerMessage('POST /register')
    //         ->developerExtraMessage(['ip' => request()->ip()])
    //         ->applicationExtraMessage(['debug' => 'custom app info'])
    //         ->create();

    //     $this->assertDatabaseHas('activity_logs', [
    //         'id' => $log->id,
    //     ]);
    // }
    // public function test_create_log_with_authenticated_user(): void
    // {
    //     $user = User::factory()->create()->fresh();

    //     // fake authentication
    //     $this->actingAs($user);


    //     $log = activity()
    //         ->humanMessage('User registered')
    //         ->humanExtraMessage(['email' => $user->email])
    //         ->developerMessage('POST /register')
    //         ->developerExtraMessage(['ip' => request()->ip()])
    //         ->applicationExtraMessage(['debug' => 'custom app info'])
    //         ->create();

    //     $this->assertDatabaseHas('activity_logs', [
    //         'id' => $log->id,
    //         'made_by_model_id' => $user->id,
    //         'made_by_model_type' => User::class,
    //     ]);
    // }

    // public function test_activity_succeeds_if_at_least_one_field_is_set(): void
    // {
    //     $user = User::factory()->create();
    //     $this->actingAs($user);

    //     $log = activity()
    //         ->madeByModel($user)
    //         ->humanMessage('Something happened') // ✅ at least one field set
    //         ->create();

    //     $this->assertDatabaseHas('activity_logs', [
    //         'id' => $log->id,
    //         'made_by_model_id' => $user->id,
    //     ]);
    // }

    // public function test_activity_fail_when_create(): void
    // {
    //     $user = User::factory()->create()->fresh();

    //     // fake authentication
    //     $this->actingAs($user);

    //     $this->expectException(\RuntimeException::class);
    //     $this->expectExceptionMessage('At least one or more fields (humanMessage, humanExtraMessage, developerMessage, developerExtraMessage, applicationExtraMessage) must be set before calling create().');

    //     activity()->create();
    // }



}
