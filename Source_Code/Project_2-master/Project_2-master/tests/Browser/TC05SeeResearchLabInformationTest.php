<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TC05SeeResearchLabInformationTest extends DuskTestCase
{
    /**
     * ทดสอบการเข้าถึงและดูข้อมูลโครงการวิจัย
     *
     * @return void
     */
    public function testSeeResearchProjectInformation()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000') // ไปที่หน้าแรก
                    ->clickLink('Research Project') // คลิกที่ลิงก์ "Research Project" ในแถบนำทาง
                    ->assertPathIs('/researchproject') // ยืนยันว่าอยู่ในเส้นทาง /researchproject
                    ->waitForText('โครงการบริการวิชาการ/ โครงการวิจัย') // รอจนกว่าข้อความ "โครงการบริการวิชาการ/ โครงการวิจัย" จะปรากฏ
                    ->assertSee('โครงการบริการวิชาการ/ โครงการวิจัย') // ตรวจสอบว่ามีข้อความ "โครงการบริการวิชาการ/ โครงการวิจัย" ปรากฏอยู่
                    ->waitFor('#example1') // รอจนกว่าองค์ประกอบที่มี ID "example1" จะปรากฏ
                    ->assertPresent('#example1'); // ตรวจสอบว่ามีองค์ประกอบที่มี ID "example1" ปรากฏอยู่
        });
    }
}
