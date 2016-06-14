<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
class ComplanFunctionTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCreateComplain()
    {
        //cara login
/*        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);*/

        $user = User::whereEmpId(196)->first();
        $this->actingAs($user);

        $this->assertTrue(true);
        $this->visit('/complain/create');
//        $this->type('223', 'register_user_id');
        $this->select('1-107', 'complain_category_id');
        $this->select('20', 'branch_id');
        $this->select('238', 'lokasi_id');
        $this->select('1558', 'ict_no');
        $this->select('1', 'complain_source_id');
        $this->type('test input using phpunit testing2', 'complain_description');
//        $this->attach('D:\IMG1179.jpg', 'complain_attachment');
        $this->press('Hantar');
        $this->seePageIs('/complain');
        $this->see('Senarai Aduan');

    }
}
