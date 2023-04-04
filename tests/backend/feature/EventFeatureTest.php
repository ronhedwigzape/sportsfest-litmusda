<?php
require_once 'tests/backend/_init.php';


class EventFeatureTest extends PHPUnit\Framework\TestCase
{
    protected Event $event;

    public function setUp(): void
    {
        resetDatabase();

        // insert a competition
        $competition = new Competition();
        $competition->setSlug('test');
        $competition->setTitle('Test');
        $competition->insert();

        // insert a category
        $category = new Category();
        $category->setCompetitionId($competition->getId());
        $category->setSlug('test');
        $category->setTitle('Test');
        $category->insert();

        // insert $this->event
        $this->event = new Event();
        $this->event->setCategoryId($category->getId());
        $this->event->setSlug('oration');
        $this->event->setTitle('Oration');
        $this->event->insert();
    }

    /** @test */
    public function criterion_can_be_related_to_event()
    {
        // insert a new criterion
        $criterion = new Criterion();
        $criterion->setTitle('Delivery');
        $criterion->setPercentage(40);
        $criterion->setEventId($this->event->getId());
        if(!Criterion::findById($criterion->getPercentage()))
            $criterion->insert();

        // search criterion in event
        $found_criterion = null;
        foreach($this->event->getRowCriteria() as $c)
        {
            if($c['id'] == $criterion->getId()) {
                $found_criterion = $c;
                break;
            }
        }

        // final test
        $this->assertNotNull($found_criterion);
        $this->assertEquals($this->event->getId(), $found_criterion['event_id']);
    }
}