<?php


namespace App\Model\example;

class PlayerScore
{
    const BASE_SCORE_MULTIPLY = 4;
    const LEADER_MULTIPLY     = 1.5;
    // 満貫以上の点数
    const MANGAN_SCORE        = 8000;
    const HANEMAN_SCORE       = 12000;
    const BAIMAN_SCORE        = 16000;
    const SANBAIMAN_SCORE     = 24000;
    const YAKUMAN_SCORE       = 32000;
    // 満貫以上の上限翻数
    const MANGAN_LIMIT        = 5;
    const HANEMAN_LIMIT       = 7;
    const BAIMAN_LIMIT        = 10;
    const SANBAIMAN_LIMIT     = 12;

    private $hanPoint;
    private $fuPoint;
    private $isLeader;

    public function __construct(int $hanPoint, int $fuPoint, bool $isLeader)
    {
        $this->hanPoint = $hanPoint;
        $this->fuPoint = $fuPoint;
        $this->isLeader = $isLeader;
    }

    /**
     * 点数を取得計算
     * @return int
     */
    public function getScore():int
    {
        // 満貫以上の場合は計算が異なる
        if (self::MANGAN_LIMIT <= $this->hanPoint) {
            return $this->calcManganOver();
        }

        return $this->calcManganUnder();
    }


    /**
     * 親か子かによっての倍率を返却する
     *
     * @return float
     */
    private function getRoleMultiply():float
    {
        return (float)($this->isLeader ? self::LEADER_MULTIPLY : 1);
    }

    /**
     * 満貫以上の計算をする
     *
     * @return int
     */
    private function calcManganOver():int
    {
        //親か子での倍率
        $roleMultiply = $this->getRoleMultiply();

        if (self::SANBAIMAN_LIMIT < $this->hanPoint) {
            $score = self::YAKUMAN_SCORE;
        } else if (self::BAIMAN_LIMIT < $this->hanPoint) {
            $score = self::SANBAIMAN_SCORE;
        } else if (self::HANEMAN_LIMIT < $this->hanPoint) {
            $score = self::BAIMAN_SCORE;
        } else if (self::MANGAN_LIMIT < $this->hanPoint) {
            $score = self::HANEMAN_SCORE;
        } else {
            $score = self::MANGAN_SCORE;
        }

        return (int)$score * $roleMultiply;
    }

    /**
     * 満貫以下の計算をする
     *
     * @return int
     */
    private function calcManganUnder():int
    {
        //親か子での倍率
        $roleMultiply = $this->getRoleMultiply();

        $baseMultiply = self::BASE_SCORE_MULTIPLY * $roleMultiply;
        $manganScore  = self::MANGAN_SCORE * $roleMultiply;

        // ツモピンフ チートイツの場合は切り上がらないため30符以上の1桁は切り上げる
        if ($this->fuPoint > 30) {
            $this->fuPoint = ceil($this->fuPoint);
        }
        // 符 ✕ 4 ✕ (親なら1.5) ✕ 2の(翻+2)数乗 ＝ 点数
        $score = $this->fuPoint * $baseMultiply * pow(2, $this->hanPoint + 2);

        //10の位を切り上げ
        $score = ceil($score/100)*100;

        //満貫の点数を超えたら満貫の点数になる
        if ($manganScore < $score) {
            $score = $manganScore;
        }

        return (int)$score;
    }
}
