<?php
//config.php
include 'credentials.php'; //database credentials
define('THIS_PAGE',basename($_SERVER['PHP_SELF'])); //basename strips off rest of path
define('DEBUG',TRUE); #we want to see all errors
// echo THIS_PAGE;
// die; (ends execution so it never gets to header or anything after)

date_default_timezone_set('America/Los_Angeles'); #sets default date/timezone for this website

# End Config area --------------------------------
ob_start();  #buffers our page to be prevent header errors. Call before INC files or ANY html!
header("Cache-Control: no-cache");header("Expires: -1");#Helps stop browser & proxy caching

$title = THIS_PAGE; //fallback unique title - see title tag in header.php
if(DEBUG)
{# When debugging, show all errors & warnings
	ini_set('error_reporting', E_ALL | E_STRICT);  
}else{# zero will hide everything except fatal errors
	ini_set('error_reporting', 0);  
}  

$nav1['template.php'] = "Home";
$nav1['hawaii.php'] = "Hawaii";
$nav1['jamaica.php'] = "Jamaica";
//$nav1['fiji.php'] = "Fiji";
$nav1['improved-customers.php'] = "Customers";
$nav1['contact.php'] = "Contact";
$nav1['request.php'] = "Request Info";

/*echo '<pre>';
var_dump(makeLinks($nav1));
echo '</pre>/';
die;*/

switch(THIS_PAGE)
{
	case 'fiji.php':
		$banner = "Site Banner";
		$bannerImage = 'fiji.jpg';		
		break;
	case 'jamaica.php':
		$banner = "Site Banner";
		$bannerImage = 'jamaica.jpg';
		break;
	case 'hawaii.php':
		$banner = "Site Banner";
		$bannerImage = 'hawaii.jpg';
		break;
	default:
		$title = "My Travel Site";
		$banner = "Site Banner";
		$bannerImage = 'sunset.jpg';
}

function makeLinks($nav)
{
	$myReturn = '';
	foreach($nav as $url => $label)
	{
		
		if($url == THIS_PAGE)
		{//current page, add class
			$myReturn .= '<li class="current"><a href="' . $url . '">' . $label . '</a></li>';
		}else{//no class
			$myReturn .= '<li><a href="' . $url . '">' . $label . '</a></li>';	
		}
					
	}
	
	return $myReturn;
}

/*
Builds and sends a safe email, using Reply-To properly!

$today = date("Y-m-d H:i:s");
$to = 'rsoude01@seattlecentral.edu';
$replyTo = 'anaphasia@gmail.com';
$subject = 'Test Email, Includes ReplyTo: ' . $today;
$message = 'Test Message Here.  Below should be a carriage return or two: ' . PHP_EOL . PHP_EOL .
    'Here is some more text.  Hopefully BELOW the carriage return!
';

safeEmail($to, $subject, $message, $replyTo='');
*/
function safeEmail($to, $subject, $message, $replyTo='') //if no fourth parameter is set, default value of empty set is used.
{#builds and sends a safe email, using Reply-To properly!
    $fromDomain = $_SERVER["SERVER_NAME"];
    $fromAddress = "noreply@" . $fromDomain; //form always submits from domain where form resides
    if($replyTo==''){$replyTo='';} //probably not needed
    $headers = 'From: ' . $fromAddress . PHP_EOL .
        'Reply-To: ' . $replyTo . PHP_EOL .
        'X-Mailer: PHP/' . phpversion();
    return mail($to, $subject, $message, $headers);
}

function process_post()
{//loop through POST vars and return a single string
    $myReturn = ''; //set to initial empty value

    foreach($_POST as $varName=> $value)
    {#loop POST vars to create JS array on the current page - include email
         $strippedVarName = str_replace("_"," ",$varName);#remove underscores
        if(is_array($_POST[$varName]))
         {#checkboxes are arrays, and we need to collapse the array to comma separated string!
             $myReturn .= $strippedVarName . ": " . implode(",",$_POST[$varName]) . PHP_EOL;
         }else{//not an array, create line
             $myReturn .= $strippedVarName . ": " . $value . PHP_EOL;
         }
    }
    return $myReturn;
} 


function myerror($myFile, $myLine, $errorMsg)
{
    if(defined('DEBUG') && DEBUG)
    {
       echo "Error in file: <b>" . $myFile . "</b> on line: <b>" . $myLine . "</b><br />";
       echo "Error Message: <b>" . $errorMsg . "</b><br />";
       die();
    }else{
        echo "I'm sorry, we have encountered an error.  Would you like to buy some socks?";
        die();
    }
}

/**
 * Wrapper function for processing data pulled from db
 *
 * Forward slashes are added to MySQL data upon entry to prevent SQL errors.  
 * Using our dbOut() function allows us to encapsulate the most common functions for removing  
 * slashes with the PHP stripslashes() function, plus the trim() function to remove spaces.
 *
 * Later, we can add to this function sitewide, as new requirements or vulnerabilities develop.
 *
 * @param string $str data as pulled from MySQL
 * @return $str data cleaned of slashes, spaces around string, etc.
 * @see dbIn()
 * @todo none
 */
function dbOut($str)
{
	if($str!=""){$str = stripslashes(trim($str));}//strip out slashes entered for SQL safety
	return $str;
} #End dbOut()