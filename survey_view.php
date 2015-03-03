<?php
/**
 * 
 * survey_view.php works with index.php (previously survey_list.php) to create a list/view app
 * 
 * demo_list_pager.php along with demo_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the 
 * Pager class which processes a mysqli SQL statement and spans records across multiple  
 * pages. 
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php. 
 * The only difference is the pager version links to the list pager version to create a 
 * separate application from the original list/view. 
 * 
 * @package SurveySez
 * @author Mark Pfaff <markdpfaff@gmail.com>
 * @version 1.0 2015/02/03
 * @link http://www.markpfaff.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see demo_view_pager.php
 * @see Pager_inc.php 
 * @todo add class code
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
# check variable of item passed in - if invalid data, forcibly redirect back to demo_list_pager.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

//original above: myRedirect(VIRTUAL_PATH . "demo/demo_list_pager.php");

$mySurvey = new Survey($myID);


if ($mySurvey->isValid){
    $config->titleTag = $mySurvey->Title . "survey!";
}else{//no such survey
    $config->titleTag = "No such survey!";
}


//dumpDie($mySurvey);


get_header(); #defaults to theme header or header_inc.php

echo '<h3 align="center">' . $config->titleTag . '</h3>';

if($mySurvey->isValid)
{ #check to see if we have a valid SurveyID
	echo "Survey #" . $mySurvey->SurveyID . " - ";
	echo $mySurvey->Title . "<br />";
	echo $mySurvey->Description . "<br /><br />";
	$mySurvey->showQuestions();
        echo '<div align="center"><a href="' . VIRTUAL_PATH . 'surveys/index.php">Back to Survey List</a></div>';
        echo SurveyUtil::responseList($myID);
}else{
	echo "Sorry, no such survey!";	
}

get_footer();

