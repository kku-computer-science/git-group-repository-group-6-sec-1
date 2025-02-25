<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC04OpenTheInformationPageTest extends DuskTestCase
{
    /**
     * ทดสอบการเปิดหน้าข้อมูลของ ศ.ดร. ศาสตรา วงศ์ธนวสุ
     *
     * @return void
     */
    public function test_view_user_profile()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000')  // ไปที่หน้าแรกของเว็บไซต์
                    ->waitFor('#navbarDropdown', 10)  // รอให้ปุ่ม "Researchers" ปรากฏ
                    ->click('#navbarDropdown')  // คลิกที่ปุ่ม "Researchers"
                    ->waitForText('Computer Science', 10)  // รอให้ตัวเลือก "Computer Science" ปรากฏ
                    ->clickLink('Computer Science')  // คลิกที่ลิงก์ "Computer Science"
                    ->waitForText('Sartra Wongthanavasu, Ph.D.', 10)  // รอให้การ์ดของ ศ.ดร. ศาสตรา ปรากฏ
                    ->clickLink('Sartra Wongthanavasu, Ph.D.')  // คลิกที่การ์ดของ ศ.ดร. ศาสตรา
                    ->waitForText('ศ.ดร. ศาสตรา วงศ์ธนวสุ', 10)  // รอให้หน้าข้อมูลของ ศ.ดร. ศาสตรา โหลด
                    ->assertSee('ศ.ดร. ศาสตรา วงศ์ธนวสุ');  // ตรวจสอบว่ามีข้อความ "ศ.ดร. ศาสตรา วงศ์ธนวสุ" ปรากฏ
        });
    }
}
