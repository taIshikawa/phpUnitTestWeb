<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Model\Player;

//https://qiita.com/rev84/items/12fbd16d210d6a86eff9

class PlayerTest extends TestCase
{
//    /**
//     * Playerクラスのインスタンスが作成されるかを確認する
//     * @test
//     *
//     * @return void
//     */
//    public function createInstance()
//    {
//        $turn = 1;
//        $sut = new Player(1);
//        //インスタンスのアサーション
//        $this->assertInstanceOf(Player::class, $sut);
//    }

    /**
     * 自分の風を取得する
     * @dataProvider getNextWindProvider
     * @test
     *
     * @param $turn
     * @param $roundNum
     * @param $expect
     * @param $message
     * @return void
     */
    public function getNextWind($turn, $roundNum, $expect, $message)
    {
        $sut = new Player($turn);

        $actual = $sut->getNextWind($roundNum);

        //アサーションの実行
        $this->assertSame($expect, $actual, $message);
    }

    public function getNextWindProvider()
    {
        return [
            //東家
            [1, 1, 'east',  '自分の風を取得する（東家）'],
            [1, 2, 'north',  '自分の風を取得する（東家）'],
            [1, 3, 'west',  '自分の風を取得する（東家）'],
            [1, 4, 'south',  '自分の風を取得する（東家）'],
            //南家
            [2, 1, 'south',  '自分の風を取得する（南家）'],
            [2, 2, 'east',  '自分の風を取得する（南家）'],
            [2, 3, 'north',  '自分の風を取得する（南家）'],
            [2, 4, 'west',  '自分の風を取得する（南家）'],
            //西家
            [3, 1, 'west',  '自分の風を取得する（西家）'],
            [3, 2, 'south',  '自分の風を取得する（西家）'],
            [3, 3, 'east',  '自分の風を取得する（西家）'],
            [3, 4, 'north',  '自分の風を取得する（西家）'],
            //北家
            [4, 1, 'north',  '自分の風を取得する（北家）'],
            [4, 2, 'west',  '自分の風を取得する（北家）'],
            [4, 3, 'south',  '自分の風を取得する（北家）'],
            [4, 4, 'east',  '自分の風を取得する（北家）'],
        ];
    }

    /**
     * 親かどうかを取得する
     * @dataProvider getNestIsLeaderProvider
     * @test
     *
     * @param $turn
     * @param $roundNum
     * @param $expect
     * @param $message
     * @return void
     */
    public function getNestIsLeader($turn, $roundNum, $expect, $message)
    {
        $sut = new Player($turn);

        $actual = $sut->getNestIsLeader($roundNum);

        //アサーションの実行
        $this->assertSame($expect, $actual, $message);
    }

    public function getNestIsLeaderProvider()
    {
        return [
            //東家
            [1, 1, true,  '親かどうかを取得する（東家）'],
            [1, 2, false,  '親かどうかを取得する（東家）'],
            [1, 3, false,  '親かどうかを取得する（東家）'],
            [1, 4, false,  '親かどうかを取得する（東家）'],
            //北家
            [4, 1, false,  '親かどうかを取得する（北家）'],
            [4, 2, false,  '親かどうかを取得する（北家）'],
            [4, 3, false,  '親かどうかを取得する（北家）'],
            [4, 4, true,  '親かどうかを取得する（北家）'],
        ];
    }
}
