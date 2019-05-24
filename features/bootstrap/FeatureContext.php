<?php

use Behat\Behat\Tester\Exception\PendingException;
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

    /**
     * @Given API 網址為 :arg1
     * @param string $apiUrl
     */
    public function apiUrl(string $apiUrl)
    {
        throw new PendingException();
    }

    /**
     * @Given API 附帶資料為
     * @param TableNode $table
     */
    public function apiBody(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @When 以 :method 方法要求 API
     * @param string $method
     */
    public function request(string $method)
    {
        throw new PendingException();
    }

    /**
     * @Then 回傳狀態應為 :statusCode
     * @param int $statusCode
     */
    public function assertStatus(int $statusCode)
    {
        throw new PendingException();
    }

    /**
     * @Then 資料表 :tableName 應有資料
     * @param string $tableName
     * @param TableNode $table
     */
    public function assertTableRecordExisted(string $tableName, TableNode $table)
    {
        throw new PendingException();
    }
}
