<?php


namespace App\Model\example;

class Hand
{
    /*
     * 手牌
     *
     * 索子： bamboos
     * 筒子： circles
     * 萬子： characters
     * 字牌： honours
     */
    private $tiles;

    private $hanPoint;//符
    private $fuPoint;//翻

    private $yaku;//役
    private $chow;//順子
    private $pung;//刻子
    private $kong;//槓子
    private $pair;//対子

    //こいつらここにいて良いの？
    private $playWind;//自風
    private $gameWind;//場風

    /**
     * Hand constructor.
     * @param $playWind
     * @param $roundWind
     */
    public function __construct(string $playWind, string $roundWind)
    {
        $this->tiles = $this->initTiles();
        $this->hanPoint = $this->calcHan();
        $this->fuPoint = $this->calcFu();
    }

    /**
     * 配牌する
     * @return array
     */
    private function initTiles():array
    {
        return [
            'characters' => [],
            'circles'    => [],
            'bamboos'    => [],
            'honours'    => [],
        ];
    }

    /**
     * 翻数を返却
     * @return int
     */
    public function getHanPoint():int
    {
        return $this->hanPoint;
    }

    /**
     * 翻数を計算
     * @return int
     */
    private function calcHan():int
    {
        return 3;//スタブ値
    }

    /**
     * 符を返却
     */
    public function getFuPoint()
    {
        return $this->fuPoint;
    }

    /**
     * 符を計算
     */
    private function calcFu()
    {
        return 40;//スタブ値
    }

}
