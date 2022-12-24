<?php

namespace Tests\Unit;

use Chtang\Idnumber\TwId;
use PHPUnit\Framework\TestCase;

/**
 * 測試
 * 中華民國(ROC TW)身分證號、居留證號
 */
final class TwIdTest extends TestCase
{
    /**
     * test 身分證號
     *
     * 測試案例：<br>
     * - 正確案例：第1碼A~Z、第2碼1~2。<br>
     * - 錯誤案例：空字串、字串長度不正確、不正確的字號。<br>
     * - 錯誤案例：使用正確之居留證號。
     *
     * @return void
     */
    public function testVerifyIdByNative(): void
    {
        //測試身分證號(正確)
        $this->assertSame(TwId::verifyIdByNative('A110164110'), true);
        $this->assertSame(TwId::verifyIdByNative('B254366133'), true);
        $this->assertSame(TwId::verifyIdByNative('C160619779'), true);
        $this->assertSame(TwId::verifyIdByNative('D217907010'), true);
        $this->assertSame(TwId::verifyIdByNative('E136944676'), true);
        $this->assertSame(TwId::verifyIdByNative('F206029221'), true);
        $this->assertSame(TwId::verifyIdByNative('G194921228'), true);
        $this->assertSame(TwId::verifyIdByNative('H255275084'), true);
        $this->assertSame(TwId::verifyIdByNative('I114457332'), true);
        $this->assertSame(TwId::verifyIdByNative('J255865301'), true);
        $this->assertSame(TwId::verifyIdByNative('K157016734'), true);
        $this->assertSame(TwId::verifyIdByNative('L201072422'), true);
        $this->assertSame(TwId::verifyIdByNative('M182972568'), true);
        $this->assertSame(TwId::verifyIdByNative('N291878914'), true);
        $this->assertSame(TwId::verifyIdByNative('O126146363'), true);
        $this->assertSame(TwId::verifyIdByNative('P230302610'), true);
        $this->assertSame(TwId::verifyIdByNative('Q148406037'), true);
        $this->assertSame(TwId::verifyIdByNative('R238202155'), true);
        $this->assertSame(TwId::verifyIdByNative('S138002145'), true);
        $this->assertSame(TwId::verifyIdByNative('T238387584'), true);
        $this->assertSame(TwId::verifyIdByNative('U184596652'), true);
        $this->assertSame(TwId::verifyIdByNative('V242507498'), true);
        $this->assertSame(TwId::verifyIdByNative('W198282584'), true);
        $this->assertSame(TwId::verifyIdByNative('X207152517'), true);
        $this->assertSame(TwId::verifyIdByNative('Y160764285'), true);
        $this->assertSame(TwId::verifyIdByNative('Z206208068'), true);

        //測試身分證號(錯誤案例)
        $this->assertSame(TwId::verifyIdByNative(''), false);
        $this->assertSame(TwId::verifyIdByNative('A12345678'), false);
        $this->assertSame(TwId::verifyIdByNative('A1234567890'), false);
        $this->assertSame(TwId::verifyIdByNative('Z106208068'), false);
        $this->assertSame(TwId::verifyIdByNative('0123456789'), false);

        //以正確居留證為案例(需測試錯誤)
        $this->assertSame(TwId::verifyIdByNative('AA19454131'), false);
        $this->assertSame(TwId::verifyIdByNative('ZB37304753'), false);
        $this->assertSame(TwId::verifyIdByNative('GC66049400'), false);
        $this->assertSame(TwId::verifyIdByNative('AD91715842'), false);
        $this->assertSame(TwId::verifyIdByNative('A897511428'), false);
        $this->assertSame(TwId::verifyIdByNative('A955316078'), false);
    }

    /**
     * test 新式外來人口統一證號
     *
     * 測試案例：<br>
     * - 正確案例：第1碼A~Z、第2碼8~9。<br>
     * - 錯誤案例：空字串、字串長度不正確、不正確的字號。<br>
     * - 錯誤案例：使用正確之身分證號。<br>
     * - 錯誤案例：使用正確之舊式居留證號。
     *
     * @return void
     */
    public function testVerifyIdByResident(): void
    {
        //測試新式外來人口統一證號(正確)
        $this->assertSame(TwId::verifyIdByResident('A808636696'), true);
        $this->assertSame(TwId::verifyIdByResident('B985348123'), true);
        $this->assertSame(TwId::verifyIdByResident('C831115177'), true);
        $this->assertSame(TwId::verifyIdByResident('D982343708'), true);
        $this->assertSame(TwId::verifyIdByResident('E896949084'), true);
        $this->assertSame(TwId::verifyIdByResident('F923292884'), true);
        $this->assertSame(TwId::verifyIdByResident('G856750863'), true);
        $this->assertSame(TwId::verifyIdByResident('H901531106'), true);
        $this->assertSame(TwId::verifyIdByResident('I829592968'), true);
        $this->assertSame(TwId::verifyIdByResident('J960255571'), true);
        $this->assertSame(TwId::verifyIdByResident('K887265285'), true);
        $this->assertSame(TwId::verifyIdByResident('L933113616'), true);
        $this->assertSame(TwId::verifyIdByResident('M866313545'), true);
        $this->assertSame(TwId::verifyIdByResident('N994492410'), true);
        $this->assertSame(TwId::verifyIdByResident('O838465180'), true);
        $this->assertSame(TwId::verifyIdByResident('P985036076'), true);
        $this->assertSame(TwId::verifyIdByResident('Q806630555'), true);
        $this->assertSame(TwId::verifyIdByResident('R991998230'), true);
        $this->assertSame(TwId::verifyIdByResident('S897215186'), true);
        $this->assertSame(TwId::verifyIdByResident('T930300061'), true);
        $this->assertSame(TwId::verifyIdByResident('U867539344'), true);
        $this->assertSame(TwId::verifyIdByResident('V988710708'), true);
        $this->assertSame(TwId::verifyIdByResident('W856665014'), true);
        $this->assertSame(TwId::verifyIdByResident('X942890867'), true);
        $this->assertSame(TwId::verifyIdByResident('Y813668332'), true);
        $this->assertSame(TwId::verifyIdByResident('Z957227084'), true);

        //測試新式外來人口統一證號(錯誤案例)
        $this->assertSame(TwId::verifyIdByResident(''), false);
        $this->assertSame(TwId::verifyIdByResident('P98503607'), false);
        $this->assertSame(TwId::verifyIdByResident('A8086366963'), false);
        $this->assertSame(TwId::verifyIdByResident('B985348124'), false);
        $this->assertSame(TwId::verifyIdByResident('0985348123'), false);

        //以正確身分證號為案例(需測試錯誤)
        $this->assertSame(TwId::verifyIdByResident('M182972568'), false);
        $this->assertSame(TwId::verifyIdByResident('U184596652'), false);

        //以正確舊式居留證為案例(需測試錯誤)
        $this->assertSame(TwId::verifyIdByResident('AA19454131'), false);
        $this->assertSame(TwId::verifyIdByResident('AD91715842'), false);
    }

    /**
     * test 舊式外來人口統一證號
     *
     * 測試案例：<br>
     * - 正確案例：第1碼A~Z、第2碼A~D。<br>
     * - 錯誤案例：空字串、字串長度不正確、不正確的字號。<br>
     * - 錯誤案例：使用正確之身分證號。<br>
     * - 錯誤案例：使用正確之新式居留證號。
     *
     * @return void
     */
    public function testVerifyIdByResidentOld(): void
    {
        //測試舊式外來人口統一證號(正確)
        $this->assertSame(TwId::verifyIdByResidentOld('AA64443286'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('BB18122115'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('CC96433621'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('DD88845405'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('EA59609187'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('FB93010743'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('GC15320072'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('HD59509958'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('IA65939612'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('JB82294905'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('KC28238746'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('LD72392266'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('MA30844439'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('NB54046929'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('OC86114441'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('PD95971419'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('QA40261016'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('RB17768316'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('SC96379189'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('TD54681767'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('UA77031993'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('VB14812026'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('WC74686822'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('XD78513660'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('YA13416341'), true);
        $this->assertSame(TwId::verifyIdByResidentOld('ZB37304753'), true);

        //測試舊式外來人口統一證號(錯誤案例)
        $this->assertSame(TwId::verifyIdByResidentOld(''), false);
        $this->assertSame(TwId::verifyIdByResidentOld('XD7851366'), false);
        $this->assertSame(TwId::verifyIdByResidentOld('SC963791899'), false);
        $this->assertSame(TwId::verifyIdByResidentOld('ZB37304754'), false);
        $this->assertSame(TwId::verifyIdByResidentOld('0985348123'), false);

        //以正確身分證號為案例(需測試錯誤)
        $this->assertSame(TwId::verifyIdByResidentOld('M182972568'), false);
        $this->assertSame(TwId::verifyIdByResidentOld('U184596652'), false);

        //以正確新式居留證為案例(需測試錯誤)
        $this->assertSame(TwId::verifyIdByResidentOld('A808636696'), false);
        $this->assertSame(TwId::verifyIdByResidentOld('B985348123'), false);
    }
}
