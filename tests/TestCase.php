<?php

namespace Mlk9\SmsPackage\Tests;

use Mlk9\Sms\SmsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
  }

  protected function getPackageProviders($app)
  {
    return [
      SmsServiceProvider::class,
    ];
  }
}
