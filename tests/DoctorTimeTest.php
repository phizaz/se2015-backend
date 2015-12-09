<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\DoctorTime;

class DoctorTimeTest extends TestCase
{

    public function testGetFreeSlotByDoctor() {
      // $result = DoctorTime::getFreeSlotByDoctor(9);

      // var_dump($result);

      // $this->assertFalse(true);
    }

    public function testConvertTimeToBlock() {
      $datetime = new DateTime();
      $datetime->setTime(8,0);

      $this->assertEquals(0, DoctorTime::timeToBlock($datetime));

      $datetime->setTime(8, 30);
      $this->assertEquals(2, DoctorTime::timeToBlock($datetime));

      $datetime->setTime(10, 0);
      $this->assertEquals(8, DoctorTime::timeToBlock($datetime));

      $datetime->setTime(12, 0);
      $this->assertEquals(16, DoctorTime::timeToBlock($datetime));
    }

    public function testConvertBlockToTime() {
      $block = 0;
      $time = new DateTime();
      $time->setTime(8, 0);
      $tmp = DoctorTime::blockToTime($block);

      $this->assertEquals(0, $tmp->diff($time)->i);
      $this->assertEquals(0, $tmp->diff($time)->h);
      $this->assertEquals(0, $tmp->diff($time)->y);
      $this->assertEquals(0, $tmp->diff($time)->m);
      $this->assertEquals(0, $tmp->diff($time)->d);

      $block = 2;
      $time = new DateTime();
      $time->setTime(8, 30);
      $tmp = DoctorTime::blockToTime($block);

      $this->assertEquals(0, $tmp->diff($time)->i);
      $this->assertEquals(0, $tmp->diff($time)->h);
      $this->assertEquals(0, $tmp->diff($time)->y);
      $this->assertEquals(0, $tmp->diff($time)->m);
      $this->assertEquals(0, $tmp->diff($time)->d);

      $block = 16;
      $time = new DateTime();
      $time->setTime(12, 0);
      $tmp = DoctorTime::blockToTime($block);

      $this->assertEquals(0, $tmp->diff($time)->i);
      $this->assertEquals(0, $tmp->diff($time)->h);
      $this->assertEquals(0, $tmp->diff($time)->y);
      $this->assertEquals(0, $tmp->diff($time)->m);
      $this->assertEquals(0, $tmp->diff($time)->d);

      $block = 16;
      $time = new DateTime();
      $time->setTime(12, 0);
      $basedate = new DateTime();
      $basedate->setDate(2010, 10, 10);
      $tmp = DoctorTime::blockToTime($block, $basedate);

      $this->assertEquals(0, $tmp->diff($time)->i);
      $this->assertEquals(0, $tmp->diff($time)->h);
      $this->assertEquals(0, $tmp->diff($basedate)->y);
      $this->assertEquals(0, $tmp->diff($basedate)->m);
      $this->assertEquals(0, $tmp->diff($basedate)->d);
    }
}
