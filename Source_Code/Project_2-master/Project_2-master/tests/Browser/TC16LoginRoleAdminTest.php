<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC16LoginRoleAdminTest extends DuskTestCase
{
    /**
     * ทดสอบการเข้าสู่ระบบด้วยข้อมูลที่ถูกต้อง
     */
    public function testLoginWithValidCredentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000')
                    ->pause(5000) // รอให้หน้าแรกโหลด
                    ->waitFor('a.btn-solid-sm[href="/login"]', 5)
                    ->click('a.btn-solid-sm[href="/login"]')
                    ->pause(1000); // รอให้แท็บใหม่เปิดขึ้น

            // ดึง window handles ทั้งหมด
            $handles = $browser->driver->getWindowHandles();
            // สมมติว่าหน้า login เปิดในแท็บใหม่ ให้สลับไปยังแท็บสุดท้าย
            $loginWindow = $handles[count($handles) - 1];
            $browser->driver->switchTo()->window($loginWindow);

            $browser->waitForLocation('/login', 5) // รอจนกว่าหน้าเปลี่ยนเป็น /login
                    ->pause(2000) // รอให้หน้า /login โหลด
                    ->waitFor('#username', 5) // รอจนกว่าช่อง username ปรากฏ
                    ->waitFor('#password', 5) // รอจนกว่าช่อง password ปรากฏ
                    ->waitFor('button[type=submit]', 5) // รอจนกว่าปุ่ม Log In ปรากฏ
                    ->type('#username', 'admin@gmail.com')
                    ->type('#password', '12345678')
                    ->click('button[type=submit]')
                    ->waitForLocation('/dashboard', 5) // รอจนกว่าหน้าจะเปลี่ยนเป็น Dashboard
                    ->assertPathIs('/dashboard');
        });
    }
}