<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC18EditUserInformationTest extends DuskTestCase
{
    /**
     * TC18 : แก้ไขข้อมูลผู้ใช้
     *
     * ขั้นตอน:
     * 1. คลิกแท็บ Users
     * 2. คลิก Action (ไอคอนรูปดินสอ) เพื่อแก้ไขข้อมูล
     * 3. แก้ไขข้อมูล
     * 4. กดปุ่ม Submit
     *
     * Expect Result:
     * - กลับมาหน้า http://127.0.0.1:8000/users
     * - ข้อมูลอัปเดตแล้ว
     */
    public function testEditUserInformation()
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

            // คลิก Action (ไอคอนรูปดินสอ) เพื่อแก้ไขข้อมูล
            $browser->click('a.btn.btn-outline-success.btn-sm[href="http://127.0.0.1:8000/users/1/edit"]')
                    ->pause(2000); // รอให้หน้าแก้ไขข้อมูลผู้ใช้แสดง

            // แก้ไขข้อมูล
            $browser->waitFor('input[name="fname_th"]', 5)
                    ->type('input[name="fname_th"]', 'ผู้ดูแลระบบใหม่') // แก้ไขชื่อภาษาไทย
                    ->type('input[name="lname_th"]', 'ใหม่') // แก้ไขนามสกุลภาษาไทย
                    ->type('input[name="fname_en"]', 'admin_updated') // แก้ไขชื่อภาษาอังกฤษ
                    ->type('input[name="lname_en"]', 'updated') // แก้ไขนามสกุลภาษาอังกฤษ
                    ->type('input[name="email"]', 'admin_update@gmail.com') // แก้ไขอีเมล
                    ->type('input[name="password"]', '12345678') // แก้ไขรหัสผ่าน
                    ->type('input[name="password_confirmation"]', '12345678') // ยืนยันรหัสผ่าน
                    ->select('select[name="roles[]"]', 'admin') // เลือกบทบาท
                    ->select('select[name="status"]', '1') // เลือกสถานะ
                    ->select('select[name="cat"]', '1') // เลือกภาควิชา
                    ->select('select[name="sub_cat"]', '1') // เลือกโปรแกรม
                    ->press('Submit') // กดปุ่ม Submit
                    ->pause(2000); // รอให้ข้อมูลอัปเดต

            // ตรวจสอบว่า URL กลับมาที่หน้า users
            $browser->assertPathIs('/users');

            // ตรวจสอบข้อมูลที่อัปเดต
            $browser->assertSee('admin_updated');
        });
    }
}
    


