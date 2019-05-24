<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends TestCase implements Context
{
    use RefreshDatabase;

    /** @var string */
    private $apiUrl = '';

    /** @var array */
    private $apiBody = [];

    /** @var TestResponse */
    private $response;

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
        $this->apiUrl = $apiUrl;
    }

    /**
     * @Given API 附帶資料為
     * @param TableNode $table
     */
    public function apiBody(TableNode $table)
    {
        $this->apiBody = $table->getHash()[0];
    }

    /**
     * @When 以 :method 方法要求 API
     * @param string $method
     */
    public function request(string $method)
    {
        $this->response = $this->json($method, $this->apiUrl, $this->apiBody);
    }

    /**
     * @Then 回傳狀態應為 :statusCode
     * @param int $statusCode
     */
    public function assertStatus(int $statusCode)
    {
        $this->response->assertStatus($statusCode);
    }

    /**
     * @Then 資料表 :tableName 應有資料
     * @param string $tableName
     * @param TableNode $table
     */
    public function assertTableRecordExisted(string $tableName, TableNode $table)
    {
        $this->assertDatabaseHas($tableName, $table->getHash()[0]);
    }
}
