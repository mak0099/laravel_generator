<?php

return [

   'title'=> 'Laravel Generator',
   'view_root'=> 'dashboard.contents.',
   'input_date_format'=> 'd/m/Y', // Use same date format in frontend datetimepicker

   'modules'=> [
      'database'=>[
         'upload_file_location'=>'uploads/database/', //from public
         'upload_max_file_size'=>'500', //in KB
         'upload_accept_file_type'=>'png,jpg,jpeg,bmp',
         'use_datatable'=>false,
      ],
   ],
];
