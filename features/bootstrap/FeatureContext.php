<?php

use Behat\Behat\Context\Context;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

/**
 * Defines application features from the specific context.
 */
abstract class FeatureContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected const ENV_FILE = '.env.behat';

    /**
     * @var Application
     */
    protected static $contextSharedApp;

    /**
     * @return Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app->loadEnvironmentFrom(self::ENV_FILE);

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @BeforeScenario
     */
    public function before(): void
    {
        if (!static::$contextSharedApp) {
            $this->setUp();
            static::$contextSharedApp = $this->app;
        } else {
            $this->app = static::$contextSharedApp;
        }

    }

    /**
     * @AfterScenario
     */
    public function after(): void
    {
        if (static::$contextSharedApp) {
            $this->tearDown();
            static::$contextSharedApp = null;
        }
    }
}
