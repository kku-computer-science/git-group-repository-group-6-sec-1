<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC06_OpenToSeeResearchGroup extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000') // ไปที่หน้าแรก
            ->waitFor('#navbarDropdown', 3)  // รอให้ปุ่ม "Researchers" ปรากฏ
            ->click('#navbarDropdown')  // คลิกที่ปุ่ม "Researchers"
            ->waitForText('Computer Science', 3)  // รอให้ตัวเลือก "Computer Science" ปรากฏ
            ->clickLink('Computer Science')  // คลิกที่ลิงก์ "Computer Science"
            ->waitForText('Sartra Wongthanavasu, Ph.D.', 3)  // รอให้การ์ดของ ศ.ดร. ศาสตรา ปรากฏ
            ->clickLink('Sartra Wongthanavasu, Ph.D.')  // คลิกที่การ์ดของ ศ.ดร. ศาสตรา
            ->waitForText('ศ.ดร. ศาสตรา วงศ์ธนวสุ', 3)  // รอให้หน้าข้อมูลของ ศ.ดร. ศาสตรา โหลด
            ->assertSee('ศ.ดร. ศาสตรา วงศ์ธนวสุ')  // ตรวจสอบว่ามีข้อความ "ศ.ดร. ศาสตรา วงศ์ธนวสุ" ปรากฏ
            // รอและคลิกปุ่ม Apply for Research Assistant Position
            ->waitFor('a.btn.btn-primary[href*="#"]', 5)
            ->click('a.btn.btn-primary[href*="#"]');
        });
    }
}
