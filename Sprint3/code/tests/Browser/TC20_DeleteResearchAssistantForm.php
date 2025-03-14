<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC20_DeleteResearchAssistantForm extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/login') // Open login page
                    ->type('username', 'wongsar@kku.ac.th') // Fill in the Username field
                    ->type('password', '123456789') // Fill in the Password field
                    ->press('button[type="submit"]') // Click the submit button (by its type)
                    ->assertPathIs('/dashboard'); // Check if redirected to the dashboard
            $browser->click('a.nav-link[href="http://127.0.0.1:8000/researchAssistant"]')
                    ->waitForLocation('/researchAssistant', 5);
            $browser->click('a.nav-link[href="http://127.0.0.1:8000/researchAssistant"]')
                    ->press('Delete')  // กดปุ่ม Delete
                    ->acceptDialog();   // กด "OK" บน Alert
        });
    }
}
