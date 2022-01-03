<?php
// CURRENT DATE
defined('CURRENT_DATE') OR define('CURRENT_DATE', date('Y-m-d H:i:s'));

//USER TYPES
defined('SUPER_ADMIN_USER') OR define('SUPER_ADMIN_USER', 'Super Duper Admin');
defined('ADMIN_USER') OR define('ADMIN_USER', 'Admin');
defined('STUDENT_USER') OR define('STUDENT_USER', 'Student');

//ACTIVE/ INACTIVE STATUS
defined('INACTIVE') OR define('INACTIVE', 0);
defined('ACTIVE') OR define('ACTIVE', 1);

//FAILURE/SUCCESS RESPONSE
defined('API_FAILURE_RESPONSE') OR define('API_FAILURE_RESPONSE', 0);
defined('API_SUCCESS_RESPONSE') OR define('API_SUCCESS_RESPONSE', 1);

//NO DATA FOUND/ SOMETHING WANT WRONG
defined('API_FAILURE_TRY_AGAIN_MESSAGE') OR define('API_FAILURE_TRY_AGAIN_MESSAGE', 'Something Went Wrong.Please Try Again.');
defined('NOT_DATA_FOUND_MESSAGE') OR define('NOT_DATA_FOUND_MESSAGE', 'No Data Found.');

//GENDER
defined('MALE_USER_TYPE') OR define('MALE_USER_TYPE', '1');
defined('FEMALE_USER_TYPE') OR define('FEMALE_USER_TYPE', '2');
defined('OTHERS_USER_TYPE') OR define('OTHERS_USER_TYPE', '3');

//IS LOGGED IN / NOT
defined('IS_LOGGED_IN') OR define('IS_LOGGED_IN', 1);
defined('IS_NOT_LOGGED_IN') OR define('IS_NOT_LOGGED_IN', 0);

//DEVICE TYPE
defined('ANDROID') OR define('ANDROID', 1);
defined('IOS') OR define('IOS', 2);


//TIMEZONE
defined('TIMEZONE') OR define('TIMEZONE', 'Asia/Kolkata');

//Server Key
defined('SERVER_KEY') OR define('SERVER_KEY', 'AAAAbbhSNmE:APA91bHXM20ivaxhFYVzEez6PPh7rg8OXUd7jZXCbVzeeTHRPeAPMvmnl6LQRX7iGLEywsb6m3Oq6lFVLwKxK6chuRP2BjY68l1zwfbfXwhUfqKTTdByyDLm1aRVkSGPaQYdUUZbzy8f');