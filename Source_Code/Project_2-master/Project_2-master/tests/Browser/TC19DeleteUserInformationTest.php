<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC19DeleteUserInformationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            // ล็อกอิน
            $browser->visit('http://127.0.0.1:8000')
                    ->pause(5000)
                    ->waitFor('a.btn-solid-sm[href="/login"]', 5)
                    ->click('a.btn-solid-sm[href="/login"]')
                    ->pause(1000);

            // ดึง window handles ทั้งหมด
            $handles = $browser->driver->getWindowHandles();
            $loginWindow = $handles[count($handles) - 1];
            $browser->driver->switchTo()->window($loginWindow);

            $browser->waitForLocation('/login', 5)
                    ->pause(2000)
                    ->waitFor('#username', 5)
                    ->waitFor('#password', 5)
                    ->waitFor('button[type=submit]', 5)
                    ->type('#username', 'admin@gmail.com')
                    ->type('#password', '12345678')
                    ->click('button[type=submit]')
                    ->waitForLocation('/dashboard', 5)
                    ->assertPathIs('/dashboard');

            // คลิกที่ลิงก์ใน navbar "Users" เพื่อไปที่หน้า /users
            $browser->click('a.nav-link[href="http://127.0.0.1:8000/users"]')
                    ->waitForLocation('/users', 5);

            $browser->click('#deleted')
                    ->pause(2000);

            if ($browser->driver->switchTo()->alert()) {
                $browser->acceptDialog();
            }

            // กดปุ่ม OK เพื่อยืนยันการลบ
            $browser->acceptDialog() // กดยอมรับในป็อปอัปการลบ
                    ->pause(2000); // รอให้การลบเสร็จสิ้น

            // กดปุ่ม OK อีกครั้งเพื่อยืนยัน
            $browser->acceptDialog() // กดยืนยันอีกครั้งหากมีป็อปอัป
                    ->pause(2000); // รอให้ข้อมูลลบเสร็จ

            // ตรวจสอบว่า URL กลับมาที่หน้า users
            $browser->assertPathIs('/users');
        });
    }
}
