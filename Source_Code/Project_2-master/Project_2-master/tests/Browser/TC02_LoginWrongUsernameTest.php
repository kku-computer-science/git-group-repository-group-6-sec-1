<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC02_LoginWrongUsernameTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testUserLoginWithWrongUsername()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/login') // Open login page
                    ->type('username', 'wongsar@gmail.com') // Fill in the Username field
                    ->type('password', '123456789') // Fill in the Password field
                    ->press('button[type="submit"]') // Click the submit button (by its type)
                    ->assertPathIs('/login') // Check if redirected to the dashboard
                    ->screenshot('TC02_LoginWrongUsernameTest');
        });
    }
}
