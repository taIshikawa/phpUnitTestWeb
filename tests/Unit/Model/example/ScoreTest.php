<?php

namespace Tests\Unit\Model\example;
use App\PointLog;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;

class ScoreTest extends TestCase
{
    //DBをクリアにする
//    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:refresh');
    }

    /**
     * Handクラスのインスタンスが作成されるかを確認する
     * @test
     */
    public function insert()
    {

        $attributes = [
            'player_id'  => 1,
            'turn'       => 1,
            'round_wind' => 'east',
            'round_rum'  => 1,
            'han_point'  => 5,
            'fu_point'   => 20,
            'score'      => 12000,
            'is_leader'  => 0,
        ];

//                PointLog::create($attributes);
//        DB::table('point_logs');
        PointLog::all();
//                $this->assertDatabaseHas('point_log', $attributes);
    }

}
