<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC08ResearchAssistantFormValidationFullTest extends DuskTestCase
{
    /**
     * A Dusk test to verify validation for required fields in the Research Assistant form.
     *
     * @return void
     */
    public function testResearchAssistantFormValidation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000')
                ->pause(2000) // รอให้หน้าแรกโหลด
                ->waitFor('a.btn-solid-sm[href="/login"]', 3)
                ->click('a.btn-solid-sm[href="/login"]')
                ->pause(1000); // รอให้แท็บใหม่เปิดขึ้น

            // ดึง window handles ทั้งหมด
            $handles = $browser->driver->getWindowHandles();
            // สลับไปยังแท็บสุดท้าย
            $browser->driver->switchTo()->window(end($handles));

            $browser->waitForLocation('/login', 3)
                ->pause(1000)
                ->waitFor('#username', 3)
                ->waitFor('#password', 3)
                ->waitFor('button[type=submit]', 3)
                ->type('#username', 'wongsar@kku.ac.th')
                ->type('#password', '123456789')
                ->click('button[type=submit]')
                ->waitForLocation('/dashboard', 3)
                ->assertPathIs('/dashboard');

            // คลิกที่ลิงก์ใน navbar "researchAssistant"
            $browser->click('a.nav-link[href="http://127.0.0.1:8000/researchAssistant"]')
                ->waitForLocation('/researchAssistant', 5)
                ->pause(1000);

            // ตรวจสอบว่ามีปุ่ม ADD และคลิกปุ่ม ADD
            $browser->waitFor('a.btn-primary[href="http://127.0.0.1:8000/researchAssistant/create"]', 3)
                ->click('a.btn-primary[href="http://127.0.0.1:8000/researchAssistant/create"]')
                ->waitForLocation('/researchAssistant/create', 5)
                ->pause(1000)
                ->assertPathIs('/researchAssistant/create');

            // Fill in the form fields
            $browser->select('#group_id', '3') // Select Research Group
            ->pause(500)
            ->assertValue('#group_name_en', 'Advanced GIS Technology (AGT)') // Auto-filled English Name
            ->select('#project_id', '16') // Select Research Project
            ->type('#member_count', '5') // Enter number of assistants
            ->type('#form_link', 'https://example.com/form') // Enter Form Link
            ->pause(500)
            ->press('บันทึก')
            ->pause(3000) // Wait for form submission
            ->assertPathIs('/researchAssistant'); // Check if redirected to research assistant page

        });
    }
}

