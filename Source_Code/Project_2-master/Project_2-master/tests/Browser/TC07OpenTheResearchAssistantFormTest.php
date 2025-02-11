<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC07OpenTheResearchAssistantFormTest extends DuskTestCase
{
    /**
     * A Dusk test to verify opening the Research Assistant form.
     *
     * @return void
     */
    public function testExample()
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

            $browser->waitForLocation('/login', 3) // รอจนกว่าหน้าเปลี่ยนเป็น /login
                ->pause(1000) // รอให้หน้า /login โหลด
                ->waitFor('#username', 3) // รอให้ช่อง username ปรากฏ
                ->waitFor('#password', 3) // รอให้ช่อง password ปรากฏ
                ->waitFor('button[type=submit]', 3) // รอให้ปุ่ม Log In ปรากฏ
                ->type('#username', 'wongsar@kku.ac.th')
                ->type('#password', '123456789')
                ->click('button[type=submit]')
                ->waitForLocation('/dashboard', 3) // รอจนกว่าหน้าจะเปลี่ยนเป็น Dashboard
                ->assertPathIs('/dashboard');

            // คลิกที่ลิงก์ใน navbar "researchAssistant" เพื่อไปที่หน้า /researchAssistant
            $browser->click('a.nav-link[href="http://127.0.0.1:8000/researchAssistant"]')
                ->waitForLocation('/researchAssistant', 5)
                ->pause(1000);


            // ตรวจสอบว่ามีปุ่ม ADD และคลิกปุ่ม ADD
            $browser->waitFor('a.btn-primary[href="http://127.0.0.1:8000/researchAssistant/create"]', 3)
                ->click('a.btn-primary[href="http://127.0.0.1:8000/researchAssistant/create"]')
                ->waitForLocation('/researchAssistant/create', 5)
                ->pause(1000)
                ->assertPathIs('/researchAssistant/create');

            // กรอกฟอร์มเพิ่มผู้ช่วยวิจัย
            $browser->waitFor('#group_id', 3)
            ->select('#group_id', '3') // เลือก "เทคโนโลยี GIS ขั้นสูง (AGT)"
            ->waitFor('#project_id', 3)
            ->select('#project_id', '16') // เลือก "Statistical Thai – Isarn Dialect Machine Translation System"
            ->waitFor('#member_count', 3)
            ->type('#member_count', '5') // ระบุจำนวนผู้ช่วยวิจัย

            ->pause(1000) // รอให้ข้อมูลอัปเดต
            ->press('บันทึก') // กดปุ่มบันทึก
            ->waitForLocation('/researchAssistant', 5) // ตรวจสอบว่า redirect กลับไปที่หน้า /researchAssistant
            ->assertPathIs('/researchAssistant');

        });
    }
}
