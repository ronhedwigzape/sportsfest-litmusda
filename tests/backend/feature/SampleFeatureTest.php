<?php
require_once 'tests/backend/_init.php';


class SampleFeatureTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function app_can_generate_slug()
    {
        $app = new App();
        $this->assertNotNull($app);
    }
}
