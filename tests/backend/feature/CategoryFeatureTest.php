<?php
require_once 'tests/backend/_init.php';


class CategoryFeatureTest extends PHPUnit\Framework\TestCase
{
    protected Category $category;

    public function setUp(): void
    {
        // insert $this->category
        $this->category = new Category();
        $this->category->setSlug('literary');
        $this->category->setTitle('Literary Competition');
        if(!Category::findBySlug($this->category->getSlug()))
            $this->category->insert();
    }


    /** @test */
    public function event_can_be_related_to_category()
    {
        // insert a new event
        $event = new Event();
        $event->setSlug('oration');
        $event->setTitle('Oration');
        $event->setCategoryId($this->category->getId());
        if(!Event::findBySlug($event->getSlug()))
            $event->insert();

        // search event in category
        $found_event = null;
        foreach($this->category->getRowEvents() as $c)
        {
            if($c['id'] == $event->getId()) {
                $found_event = $c;
                break;
            }
        }

        // final test
        $this->assertNotNull($found_event);
        $this->assertEquals($this->category->getId(), $found_event['category_id']);
    }
}