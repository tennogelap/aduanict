<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
class NavigationUserTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/complain/create')
            ->see('Hantar Aduan');

    }
    public function testCreateLinkIndex()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/complain')
            ->see('Senarai Aduan');

    }
    public function atestCreateComplainMenuLinkIndex()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/complain')
            ->click('Tambah Aduan')
            ->seePageIs('/complain/create')
//            ->$this->check('bagi_pihak')
        ;

    }
    public function testComplainShowLink()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/complain/149')
            ->see('Maklumat Aduan');

    }
    public function testComplainEditLink()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/complain/149/edit')
            ->see('Maklumat Aduan');

    }
    public function testVerifyComplainEditLink()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/complain/183/edit')
            ->see('Maklumbalas Pengguna');

    }
    public function testComplainPaginationLink()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/complain?page=2')
            ->see('Senarai Aduan')
            ->seePageIs('/complain?page=2');

    }
    public function testComplainReportLink()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/reports/monthly_statistic_aduan_ict')
            ->see('Statistik Aduan');

    }
    public function testComplainReportLink2()
    {
        //cara login
        $user = new User(array('name'=>'Hafizullah Kamaruddin'));
        $this->be($user);
        $this->visit('/reports/monthly_statistic_table_aduanict')
            ->see('Statistik Aduan');

    }

}
