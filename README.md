# chtang/idnumber
身分證字號檢查

# PHP版本限制
PHP >= 7.2

# 安裝
正式版
```bash
composer require chtang/idnumber
```
開發版
```bash
composer require chtang/idnumber:dev-main
```

# 使用
```bash
use Chtang\Idnumber\TwId;

//驗證本國國民身分證號
TwId::verifyIdByNative('A123456789'); // true
TwId::verifyIdByNative('A223456789'); // false

//驗證110年起新式外來人口統一證號
TwId::verifyIdByResident('A806754477'); // true
TwId::verifyIdByResident('A906754477'); // false

//驗證109年(含)以前舊式外來人口統一證號
TwId::verifyIdByResidentOld('AC17003729'); // true
TwId::verifyIdByResidentOld('AB17003729'); // false

//判斷身分證號、居留證號之性別
TwId::getSex('A123456789'); // M
TwId::getSex('A223456781'); // F
```