<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC17ViewUserInformationTest extends DuskTestCase
{
    /**
     * TC17 : ดูข้อมูลผู้ใช้
     *
     * ขั้นตอน:
     * 1. คลิกแท็บ Users
     * 2. คลิก Action (ไอคอนรูปตา) เพื่อดูรายละเอียดผู้ใช้
     * 3. คลิกปุ่ม Back
     *
     * Expect Result:
     * - แสดงข้อมูลของผู้ใช้คนนั้นๆ
     * - กลับมาหน้า http://127.0.0.1:8000/users
     */
    public function testViewUserInformation()
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
    
            // คลิก Action (ไอคอนรูปตา) เพื่อดูรายละเอียดผู้ใช้
            $browser->click('a.btn.btn-outline-primary.btn-sm[href="http://127.0.0.1:8000/users/8"]')
                    ->pause(2000); // รอให้หน้าแสดงผล
    
            // ตรวจสอบว่า URL เปลี่ยนเป็นที่ต้องการ
            $browser->assertPathIs('/users/8');
    
            // คลิกปุ่ม Back
            $browser->back()
                    ->pause(2000);
    
            // ตรวจสอบว่า URL กลับมาที่หน้าผู้ใช้
            $browser->assertPathIs('/users');
        });
    }
    
}

