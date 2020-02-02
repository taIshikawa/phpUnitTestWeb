<?php

namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Model\Hand;

class HandTest extends TestCase
{
    /**
     * Handクラスのインスタンスが作成されるかを確認する
     * @test
     */
    public function createInstance()
    {
        $sut = new Hand('', '');
        //インスタンスのアサーション
        $this->assertInstanceOf(Hand::class, $sut);
    }

    /**
     * 翻数返却テスト
     * @test
     */
    public function getHand()
    {
        $expect = 3;//求める結果

        $sut = new Hand('', '');
        $actual = $sut->getHanPoint();//テスト対象

        //インスタンスのアサーション
        $this->assertSame($expect, $actual);
    }

    /**
     * 符返却テスト
     * @test
     *
     * @return void
     */
    public function getFuPoint()
    {
        $expect = 40;

        $sut = new Hand('', '');
        $actual = $sut->getFuPoint();//テスト対象

        //インスタンスのアサーション
        $this->assertSame($expect, $actual);
    }
}
