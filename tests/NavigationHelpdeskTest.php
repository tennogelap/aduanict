<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
class NavigationHelpdeskTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        //cara login

        $user = User::whereEmpId(999)->first();
        $this->actingAs($user);
        $this->visit('/complain/create')
            ->see('Hantar Aduan');

    }
    public function testCreateLinkIndex()
    {
        //cara login
        $user = User::whereEmpId(999)->first();
        $this->actingAs($user);
        $this->visit('/complain')
            ->see('Senarai Aduan');

    }
    public function testComplainShowLink()
    {
        //cara login
        $user = User::whereEmpId(999)->first();
        $this->actingAs($user);
        $this->visit('/complain/149')
            ->see('Maklumat Aduan');

    }
    public function testComplainEditLink()
    {
        //cara login
        $user = User::whereEmpId(999)->first();
        $this->actingAs($user);
        $this->visit('/complain/149/actions')
            ->see('Maklumat Aduan');

    }
    public function testComplainPaginationLink()
    {
        //cara login
        $user = User::whereEmpId(999)->first();
        $this->actingAs($user);
        $this->visit('/complain?page=2')
            ->see('Senarai Aduan')
            ->seePageIs('/complain?page=2');

    }
    public function testComplainReportLink()
    {
        //cara login
        $user = User::whereEmpId(999)->first();
        $this->actingAs($user);
        $this->visit('/reports/monthly_statistic_aduan_ict')
            ->see('Statistik Aduan');

    }
    public function testComplainReportLink2()
    {
        //cara login
        $user = User::whereEmpId(999)->first();
        $this->actingAs($user);
        $this->visit('/reports/monthly_statistic_table_aduanict')
            ->see('Statistik Aduan');

    }

}
