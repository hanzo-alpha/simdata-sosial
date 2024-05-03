<?php

declare(strict_types=1);

//uses(RefreshDatabase::class);

test('returns a successful response', function (): void {
    $response = $this->get('/');

    $response->assertStatus(200);
});
