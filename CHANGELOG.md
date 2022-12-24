# Change Log

## [v1.1.0] - 2022-12-24
增加驗證中華民國(ROC TW)統一編號正確性

### Added
- 新增 TwTaxId::verifyId() 驗證統一編號號碼正確性
- 新增 phpunit 測試程式

## [v1.0.0] - 2022-12-22
增加驗證中華民國(ROC TW)身分證號、居留證號正確性

### Added
- 新增 TwId::getSex() 判斷身分證號、居留證號之性別
- 新增 TwId::verifyIdByNative() 驗證本國國民身分證號碼正確性
- 新增 TwId::verifyIdByResident() 驗證110年起新式外來人口統一證號正確性
- 新增 TwId::verifyIdByResidentOld() 驗證109年(含)以前舊式外來人口統一證號正確性