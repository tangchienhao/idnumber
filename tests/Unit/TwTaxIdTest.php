<?php

namespace Tests\Unit;

use Chtang\Idnumber\TwTaxId;
use PHPUnit\Framework\TestCase;

/**
 * 測試
 * 中華民國(ROC TW)統一編號
 *
 * 於專案目錄下執行phpunit測試：<br>
 * 單一檔案「vendor/bin/phpunit tests/Unit/TwTaxIdTest.php」<br>
 * 整個目錄「vendor/bin/phpunit tests」<br>
 * 整個目錄「vendor/bin/phpunit --testdox tests」
 *
 */
final class TwTaxIdTest extends TestCase
{
    /**
     * test 統一編號
     *
     * 測試案例：<br>
     * - 正確案例：測試第7位數非「7」。<br>
     * - 正確案例：測試第7位數為「7」。<br>
     * - 錯誤案例：空字串、字串長度不正確、不正確的字號。<br>
     * - 錯誤案例：使用正確之居留證號。
     *
     * @return void
     */
    public function testVerifyId(): void
    {
        //測試第7位數非「7」(正確)
        $this->assertSame(TwTaxId::verifyId('04595252'), true);
        $this->assertSame(TwTaxId::verifyId('04595257'), true);

        //測試第7位數為「7」(正確)
        $this->assertSame(TwTaxId::verifyId('10458570'), true);
        $this->assertSame(TwTaxId::verifyId('10458574'), true);
        $this->assertSame(TwTaxId::verifyId('10458575'), true);

        //測試錯誤案例
        $this->assertSame(TwTaxId::verifyId(''), false);
        $this->assertSame(TwTaxId::verifyId('0459525'), false);
        $this->assertSame(TwTaxId::verifyId('045952523'), false);
        $this->assertSame(TwTaxId::verifyId('10458571'), false);
        $this->assertSame(TwTaxId::verifyId('A4595252'), false);
    }
}
