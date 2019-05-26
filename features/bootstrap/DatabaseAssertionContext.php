<?php

use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class DatabaseAssertionContext extends FeatureContext
{
    /**
     * @Then 資料表 :tableName 應有資料
     * @param string $tableName
     * @param TableNode $table
     */
    public function assertTableRecordExisted(string $tableName, TableNode $table): void
    {
        $this->assertDatabaseHas($tableName, $table->getHash()[0]);
    }
}
