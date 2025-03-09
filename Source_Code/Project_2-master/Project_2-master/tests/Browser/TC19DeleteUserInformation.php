<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC19DeleteUserInformationTest extends DuskTestCase
{
    /**
     * TC19 : ลบผู้ใช้
     *
     * ขั้นตอน:
     * 1. คลิกแท็บ Users
     * 2. คลิก Action (ไอคอนรูปถังขยะ) เพื่อลบข้อมูล
     * 3. กดปุ่ม OK
     * 4. กดปุ่ม OK อีกครั้งเพื่อยืนยัน
     *
     * Expect Result:
     * - กลับมาหน้า http://127.0.0.1:8000/users
     * - ลบข้อมูลอัปเดตแล้ว
     */
    public function testDeleteUserInformation()
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

            // คลิก Action (ไอคอนรูปถังขยะ) เพื่อลบข้อมูล
            $browser->click('button#delete-user-5') // ใช้ id เช่น delete-user-1
                    ->pause(2000); // รอให้คำขอ confirmation ปรากฏ

            // กดปุ่ม OK เพื่อยืนยันการลบ
            $browser->acceptDialog() // กดยอมรับในป็อปอัปการลบ
                    ->pause(2000); // รอให้การลบเสร็จสิ้น

            // กดปุ่ม OK อีกครั้งเพื่อยืนยัน
            $browser->acceptDialog() // กดยืนยันอีกครั้งหากมีป็อปอัป
                    ->pause(2000); // รอให้ข้อมูลลบเสร็จ

            // ตรวจสอบว่า URL กลับมาที่หน้า users
            $browser->assertPathIs('/users');

            // ตรวจสอบว่าผู้ใช้ที่ลบหายไปจากหน้า
            $browser->assertDontSee('admin_updated'); // ห้ามพบข้อมูลที่ลบแล้ว
        });
    }
}
