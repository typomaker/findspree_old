<?php
use common\helpers\Time;

return [
    'adminEmail' => 'admin@findspree.com',
	//время с момента последнего действия до того как пользователь будет читаться оффлайн
    'onlineLength' => Time::SEC_TO_MINUTE*15,
    'supportEmail' => 'support@findspree.com',
    'user.passwordResetTokenExpire' => 3600,
];
