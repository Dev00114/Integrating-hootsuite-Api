<?php
/*Database configration*/
$hootsuite_config = [
    'database'=>[
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'port' => '3306',
            'db_name' => 'test_db',
            'hootsuite_tbl' => 'media_draft_table',
    ],
        
    'hootsuite'=>[
        'client_id'     =>  '4cb6d13f-1b85-419a-bd8a-abb682390255',
        'secret_key'    =>  'ephgviu9xW.E',
        'hootsuite_root'=>  'https://hootsuite-testing-mysite.herokuapp.com/',
        'hook_file'     =>  'callback.php',
        'redirect_file' =>  'webhook.php',
        'is_purchased'  => false,
    ]
];
