<?php

namespace Chtang\Idnumber;

/**
 * 中華民國(ROC TW)身分證號、居留證號
 */
class TwId
{
    /**
     * 判斷身分證號、居留證號之性別
     *
     * @param string $idNumber 身分證號、居留證號
     * @return string M:男; F:女; 空字串:無法判別
     */
    public static function getSex(string $idNumber): string
    {
        //本國
        if (self::verifyIdByNative($idNumber)) {
            $sexNumber = substr($idNumber, 1, 1);
            switch ($sexNumber) {
                case '1':
                    return 'M';
                case '2':
                    return 'F';
            }
        }

        //新居留證
        if (self::verifyIdByResident($idNumber)) {
            $sexNumber = substr($idNumber, 1, 1);
            switch ($sexNumber) {
                case '8':
                    return 'M';
                case '9':
                    return 'F';
            }
        }

        //舊居留證
        if (self::verifyIdByResidentOld($idNumber)) {
            $sexNumber = substr($idNumber, 1, 1);
            switch ($sexNumber) {
                case 'A':
                case 'C':
                    return 'M';
                case 'B':
                case 'D':
                    return 'F';
            }
        }

        //無法分辨
        return '';
    }

    /**
     * 字母轉換為對應之數字
     *
     * @param string $letter 大寫字母
     * @return int 對應之數值; 0為查無資料
     */
    public static function transformLetterToNumber(string $letter): int
    {
        //英文字碼轉數字陣列
        $arr_english_code = [
            'A' => 10, 'B' => 11, 'C' => 12, 'D' => 13, 'E' => 14,
            'F' => 15, 'G' => 16, 'H' => 17, 'I' => 34, 'J' => 18,
            'K' => 19, 'L' => 20, 'M' => 21, 'N' => 22, 'O' => 35,
            'P' => 23, 'Q' => 24, 'R' => 25, 'S' => 26, 'T' => 27,
            'U' => 28, 'V' => 29, 'W' => 32, 'X' => 30, 'Y' => 31,
            'Z' => 33
        ];

        //字母存在於陣列索引值中時，回傳相對應的數值。
        if (array_key_exists($letter, $arr_english_code)) {
            return $arr_english_code[$letter];
        }

        //字母不存在於陣列索引值中時，回傳0
        return 0;
    }

    /**
     * 驗證證號號碼正確性
     *
     * @param string $idNumber 身分證號碼
     * @return bool true:正確; false:錯誤
     */
    private static function verifyId(string $idNumber): bool
    {
        //先檢查傳入字串是否正確(一律大寫)，必須符合此規則才可計算。
        if (!preg_match('/^[A-Z]\d{9}$/', $idNumber)) {
            return false;
        }

        //權重陣列
        $arr_weight_number = [1, 9, 8, 7, 6, 5, 4, 3, 2, 1];

        //將第一碼英文字串轉換為對應之數字 + 證號第2~9碼 = 10碼運算字串
        $computing_code = self::transformLetterToNumber(substr($idNumber, 0, 1));
        $computing_code .= substr($idNumber, 1, 8);
        //取證號最後1碼 = 檢核碼
        $check_code = substr($idNumber, 9, 1);

        if (strlen($computing_code) !== 10 || strlen($check_code) !== 1) {
            return false;
        }

        //運算字串轉陣列
        $arr_computing_number = str_split($computing_code);
        $check_number = intval($check_code);

        //1.將每個字依權值相乘後加總
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += $arr_computing_number[$i] * $arr_weight_number[$i];
        }

        //2.將加總後的數字除10後求餘數，再以10減去餘數取個位數，即可求得檢查碼。
        $computing_check_number = (10 - ($sum % 10)) % 10;

        if ($computing_check_number === $check_number) {
            //驗證正確
            return true;
        } else {
            //驗證錯誤
            return false;
        }
    }

    /**
     * 驗證本國國民身分證號碼正確性
     *
     * @param string $idNumber 身分證號碼
     * @return bool true:正確; false:錯誤
     */
    public static function verifyIdByNative(string $idNumber): bool
    {
        //先檢查傳入字串是否正確(一律大寫)
        //第1碼：區域碼，依申請地區分。
        //第2碼：性別碼，1為男性，2為女性。
        //第3碼：身分碼，0-5為國人、6為外國人或無國籍人、7為無戶籍國民、8為港澳居民、9為大陸地區人民
        //第4至9碼是流水號
        //第10碼：檢查碼，用阿拉伯數字。
        if (preg_match('/^[A-Z][12]\d{8}$/', $idNumber)) {
            return self::verifyId($idNumber);
        }

        return false;
    }

    /**
     * 驗證110年起新式外來人口統一證號正確性
     *
     * 外來人口統一證號說明：<br>
     * 110年起外來人口統一證號驗證模式與華民國身分證相同。<br>
     * 120年1月1日起舊式統號停止使用。<br>
     * 各公務部門及公民營機(構)於120年1月1日後，若遇有民眾持舊式統號申辦相關服務時，應不予接受並請民眾至移民署換發新式統號。
     *
     * @param string $idNumber 居留證號碼
     * @return bool true:正確; false:錯誤
     */
    public static function verifyIdByResident(string $idNumber): bool
    {
        //先檢查傳入字串是否正確(一律大寫)
        //第1碼：區域碼，依申請地區分，比照國人格式。
        //第2碼：性別碼，8為男性，9為女性。
        //第3碼：身分碼，0-6為外國人或無國籍人、7為無戶籍國民、8為港澳居民、9為大陸地區人民
        //第4至9碼是流水號
        //第10碼：檢查碼，用阿拉伯數字。(和中華民國國民身分證驗證規則相同)
        if (preg_match('/^[A-Z][89]\d{8}$/', $idNumber)) {
            return self::verifyId($idNumber);
        }

        return false;
    }

    /**
     * 驗證109年(含)以前舊式外來人口統一證號正確性
     *
     * @param string $idNumber 居留證號碼
     * @return bool true:正確; false:錯誤
     */
    public static function verifyIdByResidentOld(string $idNumber): bool
    {
        //先檢查傳入字串是否正確(一律大寫)
        //第1碼：區域碼，依申請地區分，比照國人格式。
        //第2碼：性別碼，(無戶籍國民、大陸地區人民、港澳居民)A為男性，B為女性; (外國人)C為男性，D為女性。
        //第3至9碼是流水號
        //第10碼：檢查碼，用阿拉伯數字。(和中華民國國民身分證驗證規則相同)
        if (preg_match('/^[A-Z][ABCD]\d{8}$/', $idNumber)) {
            //第2碼英文轉碼成數字，並只取個位數，重新組合成'/^[A-Z]\d{9}$/'字串後，依中華民國身分證號規則驗證。
            $transformIdNumber = substr($idNumber, 0, 1);
            $transformIdNumber .= self::transformLetterToNumber(substr($idNumber, 1, 1)) % 10;
            $transformIdNumber .= substr($idNumber, 2, 8);

            return self::verifyId($transformIdNumber);
        }

        return false;
    }
}