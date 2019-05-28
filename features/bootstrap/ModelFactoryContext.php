<?php

use App\User;

/**
 * Defines application features from the specific context.
 */
class ModelFactoryContext extends FeatureContext
{
    /**
     * @Given 存在使用者 :name :email
     * @param string $name
     * @param string $email
     */
    public function user(string $name, string $email)
    {
        factory(User::class)->create([
            'name'  => $name,
            'email' => $email,
        ]);
    }
}
