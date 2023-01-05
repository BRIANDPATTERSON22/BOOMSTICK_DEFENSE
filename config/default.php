<?php

use Carbon\Carbon;

$todayDate 				=	Carbon::today();
$today 					=	$todayDate->format('Y-m-d');
$lastMonth 				=	$todayDate->modify('-30 day');
$lastMonth 				=	$lastMonth->format('Y-m-d');
$checkoutTypeArray 		=	['1' => 'Guest', '2' => 'Customer', '3' => 'Other'];
$orderStatusArray 		=	['1' => 'Pending/ Unapproved', '2' => 'Approved/ Processing', '3' => 'Completed', '4' => 'Rejected'];
$paymentStatusArray 	=	['1' => 'UNPAID/ ON HOLD', '2' => 'PAID', '3' => 'INCOMPLETED', '4' => 'FAILED', '5' => 'REFUNDED', '6' => 'ERROR'];
$deliveryStatusArray	=	['1' => 'Dispatched', '2' => 'Delivered'];
// $orderStatusArray 		=	[
// 								1 => ['Pending/ Unapproved', 'default'],
// 								2 => ['Approved/ Processing', 'warning'],
// 								3 => ['Completed', 'success'],
// 								4 => ['Rejected', 'danger'],
// 							];
$statusArray =  [0 => "Disabled", 1 => "Enabled"];
$answerArray =  [0 => "No", 1 => "Yes"];
$isAvailable =  ['Y' => "Yes", 'N' => "No"];
$contactReason =  ['1' => "Modify an Unprocessed Order", '2' => "Cancel an Unprocessed Order", '3' => "Website Issue/ Comment", '4' => "Product Question", '5' => "Other"];
$usStates = [
    'AL'=>'Alabama',
    'AK'=>'Alaska',
    'AZ'=>'Arizona',
    'AR'=>'Arkansas',
    'CA'=>'California',
    'CO'=>'Colorado',
    'CT'=>'Connecticut',
    'DE'=>'Delaware',
    'DC'=>'District of Columbia',
    'FL'=>'Florida',
    'GA'=>'Georgia',
    'HI'=>'Hawaii',
    'ID_Idaho'=>'Idaho',
    'IL'=>'Illinois',
    'IN'=>'Indiana',
    'IA'=>'Iowa',
    'KS'=>'Kansas',
    'KY'=>'Kentucky',
    'LA'=>'Louisiana',
    'ME'=>'Maine',
    'MD'=>'Maryland',
    'MA'=>'Massachusetts',
    'MI'=>'Michigan',
    'MN'=>'Minnesota',
    'MS'=>'Mississippi',
    'MO'=>'Missouri',
    'MT'=>'Montana',
    'NE'=>'Nebraska',
    'NV'=>'Nevada',
    'NH'=>'New Hampshire',
    'NJ'=>'New Jersey',
    'NM'=>'New Mexico',
    'NY'=>'New York',
    'NC'=>'North Carolina',
    'ND'=>'North Dakota',
    'OH'=>'Ohio',
    'OK'=>'Oklahoma',
    'OR'=>'Oregon',
    'PA'=>'Pennsylvania',
    'RI'=>'Rhode Island',
    'SC'=>'South Carolina',
    'SD'=>'South Dakota',
    'TN'=>'Tennessee',
    'TX'=>'Texas',
    'UT'=>'Utah',
    'VT'=>'Vermont',
    'VA'=>'Virginia',
    'WA'=>'Washington',
    'WV'=>'West Virginia',
    'WI'=>'Wisconsin',
    'WY'=>'Wyoming',
];

return [
	'today'					=>	$today,
	'year'					=>	2017,
	'popular_date'			=>	$lastMonth,
	'checkoutTypeArray'		=>	$checkoutTypeArray,
	'orderStatusArray'		=>	$orderStatusArray,
	'paymentStatusArray'	=>	$paymentStatusArray,
	'deliveryStatusArray'	=>	$deliveryStatusArray,
	'statusArray' => $statusArray,
	'answerArray' => $answerArray,
	'isAvailable' => $isAvailable,
	'contactReason' => $contactReason,
	'usStates' => $usStates,
];