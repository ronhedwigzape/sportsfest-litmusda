<?php
require_once 'tests/backend/_init.php';


class CompetitionFeatureTest extends PHPUnit\Framework\TestCase
{
    protected Competition $competition;

    public function setUp(): void
    {
        // insert $this->competition
        $this->competition = new Competition();
        $this->competition->setSlug('sports');
        $this->competition->setTitle('Sports');
        if(!Competition::findBySlug($this->competition->getSlug()))
            $this->competition->insert();
    }


    /** @test */
    public function category_can_be_related_to_competition()
    {
        // insert a new category
        $category = new Category();
        $category->setSlug('ball');
        $category->setTitle('Ball Games');
        $category->setCompetitionId($this->competition->getId());
        if(!Category::findBySlug($category->getSlug()))
            $category->insert();

        // search category in competition
        $found_category = null;
        foreach($this->competition->getRowCategories() as $c)
        {
            if($c['id'] == $category->getId()) {
                $found_category = $c;
                break;
            }
        }

        // final test
        $this->assertNotNull($found_category);
        $this->assertEquals($this->competition->getId(), $found_category['competition_id']);
    }
}
