<?php

return array(


    'pdf' => array(
        'enabled' => true,
        //'binary'  => '/usr/local/bin/wkhtmltopdf',
        'binary'  => '"C:\Program Files (x86)\wkhtmltopdf\bin\wkhtmltopdf"',
//        'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
//        'binary' => '"C:/wkhtmltopdf/wkhtmltopdf.exe"',
//        'binary' => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
