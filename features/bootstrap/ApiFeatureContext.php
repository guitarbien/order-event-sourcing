<?php

use Behat\Gherkin\Node\PyStringNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Foundation\Testing\TestResponse;

/**
 * Defines application features from the specific context.
 */
class ApiFeatureContext extends FeatureContext
{
    /**
     * @var string
     */
    private $apiUrl = '';

    /**
     * @var array
     */
    private $apiBody = [];

    /**
     * @var TestResponse
     */
    private $response;

    /**
     * @Given API 網址為 :apiUrl
     * @param string $apiUrl
     */
    public function apiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @Given API 附帶資料為
     * @param TableNode $table
     */
    public function apiBody(TableNode $table): void
    {
        $this->apiBody = $table->getHash()[0];
    }

    /**
     * @When 以 :method 方法要求 API
     * @param string $method
     */
    public function request(string $method): void
    {
        $this->response = $this->json($method, $this->apiUrl, $this->apiBody);
    }

    /**
     * @Then 回傳狀態應為 :statusCode
     * @param int $statusCode
     */
    public function assertStatus(int $statusCode): void
    {
        $this->response->assertStatus($statusCode);
    }

    /**
     * @Then 可以得到Json回傳值
     * @param TableNode $table
     */
    public function assertJsonResponse(TableNode $table)
    {
        $this->response->assertJson($table->getHash()[0]);
    }

    /**
     * @Given API JSON資料為
     * @param PyStringNode $json
     */
    public function apiJsonBody(PyStringNode $json)
    {
        $this->apiBody = json_decode($json->getRaw(), true);
    }
}
