<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends TestCase implements Context
{
    use RefreshDatabase;

    /**
     * @BeforeScenario
     */
    public function before()
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');
        $this->setUp();
    }

    /**
     * @AfterScenario
     */
    public function after()
    {
        $this->tearDown();
    }
}
