<?php
require_once 'tests/backend/_init.php';


class SampleUnitTest extends PHPUnit\Framework\TestCase
{
    protected App $app;


    public function setUp(): void
    {
        $this->app = new App();
    }


    /** @test */
    public function app_can_generate_slug()
    {
        $str  = 'Hello World!';
        $slug = $this->app::generateSlug($str);

        $this->assertEquals('hello-world', $slug);
    }
}
