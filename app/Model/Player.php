<?php


namespace App\Model;

//用語出展
//https://perceptualmahjong.blog.ss-blog.jp/2010-10-08
//https://chouseisan.com/l/post-9420/
//http://crescent.s255.xrea.com/cabinet/others/mahjong/
class Player
{
    const INIT_SCORE = 25000;
    const BASE_SCORE_MULTIPLY = 4;
    const LEADER_MULTIPLY = 1.5;
    const MANGAN_SCORE = 8000;
    const HANEMAN_SCORE = 12000;
    const BAIMAN_SCORE = 16000;
    const SANBAIMAN_SCORE = 24000;
    const YAKUMAN_SCORE = 32000;
    const MANGAN_LIMIT = 5;
    const HANEMAN_LIMIT = 7;
    const BAIMAN_LIMIT = 10;
    const SANBAIMAN_LIMIT = 12;

    private $turn;//順番親から1,2,3,4となる
    private $score;
    private $hand;
    private $isLeader;

    /*
     * 風牌
     *
     * 東： east
     * 南： south
     * 西： west
     * 北： north
     */
    private $wind;//wind型を作る

    public function __construct($turn)
    {
        $this->turn = $turn;
        $this->score = self::INIT_SCORE;
        $this->initHand();
    }

    public function initHand()
    {
        $this->nextGame('east', 1, 1);
    }

    /**
     * 次の局の自風を取得する
     *
     * @param int $roundNum
     * @return string
     */
    public function getNextWind(int $roundNum)
    {
        //親を基準点1として計算する$roundNum
        $basePoint = $this->turn - ($roundNum - 1);

        if ($basePoint === 1) {
            return 'east';//東
        } else if ($basePoint === 2 || $basePoint === -2) {
            return 'south';//南
        } else if ($basePoint === 3 || $basePoint === -1) {
            return 'west';//西
        } else if ($basePoint === 4 || $basePoint === 0) {
            return 'north';//北
        } else {
            //TODO:例外
            //ignore
        }
    }

    /**
     * 次の局を開始するための設定を行う
     * TODO: 場の牌のクラスを渡す
     *
     * @param string $roundWind
     * @param int $roundNum
     * @param int $continuation
     */
    public function nextGame(string $roundWind, int $roundNum, int $continuation)
    {
        //プロパティのwindを更新
        $this->wind = $this->getNextWind($roundNum);
        $this->isLeader = $this->getNestIsLeader($roundNum);
        $this->hand = new Hand($this->wind, $roundWind);
    }

    /**
     * 次が親かどうかを取得する
     * @param int $roundNum
     * @return bool
     */
    public function getNestIsLeader(int $roundNum):bool
    {
        return ($this->turn === $roundNum);
    }

    /**
     * 点数を取得計算
     * TODO: 流石に分離したほうがよさそう
     * @param int $hanPoint
     * @param int $fuPoint
     * @param bool $isLeader
     * @return int
     */
    public function calcScore(int $hanPoint, int $fuPoint, bool $isLeader):int
    {
        $score = 0;
        //親か子での倍率
        $roleMultiply = ($isLeader ? self::LEADER_MULTIPLY : 1);

        $baseMultiply = self::BASE_SCORE_MULTIPLY * $roleMultiply;
        $manganScore = self::MANGAN_SCORE * $roleMultiply;

        if (self::MANGAN_LIMIT <= $hanPoint) {
            if (self::SANBAIMAN_LIMIT < $hanPoint) {
                $score = self::YAKUMAN_SCORE;
            } else if (self::BAIMAN_LIMIT < $hanPoint) {
                $score = self::SANBAIMAN_SCORE;
            } else if (self::HANEMAN_LIMIT < $hanPoint) {
                $score = self::BAIMAN_SCORE;
            } else if (self::MANGAN_LIMIT < $hanPoint) {
                $score = self::HANEMAN_SCORE;
            } else {
                $score = self::MANGAN_SCORE;
            }

            return $score * $roleMultiply;
        }

        // 符 ✕ 4 ✕ (親なら1.5) ✕ 2の(翻+2)数乗 ＝ 点数
        // 30符以上の1桁は切り上げる
        if ($fuPoint > 30) {
            $fuPoint = ceil($fuPoint);
        }
        $score = $fuPoint * $baseMultiply * pow(2, $hanPoint + 2);

        //10の位を切り上げ
        $score = ceil($score/100)*100;

        if ($manganScore < $score) {
            $score = $manganScore;
        }
        return $score;
    }
}
