<?php

return [
    'force_https' => env('FORCE_HTTPS', true)
    ,'user_lock_out_count' => env('USER_LOCK_OUT_COUNT', 5)
    ,'reference_no_length' => env('REFERENCE_NO_LENGTH', 10)
    ,'flash_msg_timeout' => env('FLASH_MSG_TIMEOUT_MS', 5000) // 5 seconds
    ,'aws' => [
        'timeout_temp_url' => env('AWS_TIMEOUT_TEMP_URL', '') // in minutes
        ,'allowed_mime_files' => env('AWS_MIME_FILES', ['xlsx','csv','doc','png','jpg'])
    ]
    ,'decimal_place' => env('DECIMAL_PLACE', 4)
    ,'descriptions' => [
        'office_number' => 'Office\'s contact number'
        ,'contact_number' => 'Contact Person\'s number'
        ,'contact_email' => 'Contact Person\'s email'
        ,'expiration_days' => 'Days before expiration upon purchase'
        ,'qualified_count' => 'The criteria by quantity or count of a purchased item'
        ,'attachments' => 'Files of evidence or proof such as screenshot, image capture or document file for the request. You may upload'
        ,'config_label' => 'E.g. Minimum Wallet Amount'
        ,'field_alias' => 'This is the field alias representation of the Config. E.g. min_wallet_amount'
    ]
    ,'currency_decimal_place' => env('CURRENCY_DECIMAL_PLACE', 4)
    ,'transaction_refunds' => [
        'upload_file_limit' => env('TRANS_REFUNDS_UPLOAD_FILE_LIMIT', 5),
        'upload_max_size' => env('TRANS_REFUNDS_UPLOAD_MAX_SIZE', 3000) // in KB
    ]
    ,'wallets' => [
        'max_amount' => env('WALLET_MAX_AMOUNT', 100000000),
    ]
];