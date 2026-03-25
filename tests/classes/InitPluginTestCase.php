<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Tests\Classes;

use Mail;
use Queue;
use Storage;
use PluginTestCase;
use Illuminate\Support\Facades\Bus;

abstract class InitPluginTestCase extends PluginTestCase
{
    public function setUp(): void
    {
        @unlink('storage/cms/disabled.php');

        parent::setUp();

        Queue::fake();
        Bus::fake();

        Storage::fake();

        Mail::swap(new FakeMailer(Mail::getFacadeRoot()));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        @unlink('storage/cms/disabled.php');
    }
}
