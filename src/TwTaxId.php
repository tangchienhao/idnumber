<?php

namespace Chtang\Idnumber;

/**
 * 中華民國(ROC TW)統一編號
 */
class TwTaxId
{
    /**
     * 驗證統一編號號碼正確性(8碼全數字格式)
     *
     * 1. 驗證時，將每個位元[n0、n1、n2、n3、n4、n5、n6、n7]乘上相對應的權重[1, 2, 1, 2, 1, 2, 4, 1]<br>
     * 2. 再將每個位元的乘積的十位與個位數相加，得到一新的 8 碼數字，並將 8 碼數字總和=sum1<br>
     * 3. sum1若為 5 的倍數，即為有效的驗證碼<br>
     * <br>
     * 例外情況，就是當 n6=7 時，當其乘上對應權重4後，會得到28，十位與個位數相加後為10，此時n6分別取1、0進行相加，得到2組數字總和sum1、sum2<br>
     * sum1、sum2其中之一能被「5」整除，即為有效的驗證碼<br>
     * <br>
     * 財政部為配合修正擴增統一編號並與現行配賦之統一編號相容，修正統一編號之檢查邏輯由可被「10」整除改為可被「5」整除，預計自112年4月1日使用。<br>
     *
     * @param string $idNumber 統一編號號碼
     * @return bool true:正確; false:錯誤
     */
    public static function verifyId(string $idNumber): bool
    {
        //先檢查傳入字串是否正確(8碼數字)，必須符合此規則才可計算。
        if (!preg_match('/^\d{8}$/', $idNumber)) {
            return false;
        }

        //統一編號字串陣列
        $n = str_split($idNumber);
        //將字串陣列轉數字陣列
        foreach ($n as $item => $value) {
            $n[$item] = intval($value);
        }
        unset($value);

        //權重陣列
        $w = [1, 2, 1, 2, 1, 2, 4, 1];

        //1. 驗證時，將每個位元乘上相對應的權重
        $computing_number = [];
        for ($i = 0; $i < 8; $i++) {
            $computing_number[$i] = $n[$i] * $w[$i];
        }

        //2. 再將每個位元的乘積的十位與個位數相加，得到一新的 8 碼數字，並將 8 碼數字總和=sum1
        $sum1 = 0;
        $sum2 = 0;
        if ($n[6] == 7) {
            //n6=7時為特例
            $sumWithoutN6 = 0;
            for ($i = 0; $i < 8; $i++) {
                if ($i != 6) {
                    $sumWithoutN6 += floor($computing_number[$i] / 10) + ($computing_number[$i] % 10);
                }
            }

            //加入n6 = 7時，乘權重後為28，十位與個位數相加後為10，分別取1、0進行相加，得到2組數字總和sum、sum'
            $sum1 = $sumWithoutN6 + 1; //取十位數1相加
            $sum2 = $sumWithoutN6; //取個位數0相加
        } else {
            for ($i = 0; $i < 8; $i++) {
                $sum1 += floor($computing_number[$i] / 10) + ($computing_number[$i] % 10);
            }
        }

        //3. sum若為 5 的倍數，即為有效的驗證碼
        $computing_check = false;
        if ($n[6] == 7) {
            if ($sum1 % 5 == 0 || $sum2 % 5 == 0) {
                $computing_check = true;
            }
        } else {
            if ($sum1 % 5 == 0) {
                $computing_check = true;
            }
        }

        return $computing_check;
    }
}