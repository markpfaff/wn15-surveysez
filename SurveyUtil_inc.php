<?php

//SurveyUtil_inc.php

class SurveyUtil{
    public static function responseList($myID){
        $myReturn = '';

    //    $sql = "select CONCAT(a.FirstName, ' ', a.LastName) AdminName, s.SurveyID, s.Title, s.Description, 
    //    date_format(s.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' from " . PREFIX . "surveys s, " . PREFIX . "Admin a where s.AdminID=a.AdminID order by s.DateAdded desc";

        $sql = "select DateAdded, ResponseID from wn15_responses where SurveyID=$myID";

        #reference images for pager
        $prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
        $next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

        # Create instance of new 'pager' class
        $myPager = new Pager(10,'',$prev,$next,'');
        $sql = $myPager->loadSQL($sql);  #load SQL, add offset

        # connection comes first in mysqli (improved) function
        $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        #dumpDie($result);

        if(mysqli_num_rows($result) > 0)
        {#records exist - process
                if($myPager->showTotal()==1){$itemz = "response";}else{$itemz = "responses";}  //deal with plural
                $myReturn .= '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';

    //            $myReturn .= '<table align="center" border="1" style="border-collapse:collapse" cellpadding="3" cellspacing="3">';
    //                    $myReturn .= '<tr>
    //                                    <th>Admin Name</th>
    //                                    <th>Response ID</th>
    //                                    <th>Response Title</th>
    //                                    <th>Survey Description</th>   
    //                                    <th>Survey Date Added</th>
    //                                    <th>View Survey</th>
    //
    //                        </tr>';

                while($row = mysqli_fetch_assoc($result))
                {# process each row
    //                    $myReturn .= '<tr>
    //                                <!--<td>' . dbOut($row['AdminName']) . '</td>-->
    //                                <td>' . (int)($row['SurveyID']) . '</td>
    //                                <td>' . dbOut($row['Title']) . '</td>
    //                                <td>' . dbOut($row['Description']) . '</td>
    //                                <td>' . (int)($row['DateAdded']) . '</td>
    //                                <td><a href="' . VIRTUAL_PATH . 'surveys/response_view.php?id=' . (int)$row['ResponseID'] . '">View Response!</a></td>
    //
    //                            </tr>
    //                            ';
                    $myReturn .= '<div align="center">
                        <a href="' . VIRTUAL_PATH . 'surveys/response_view.php?id=' . (int)$row['ResponseID'] . '">' . dbOut($row['DateAdded']) . '</a>';
                }
                $myReturn .= '</table>';

                $myReturn .= $myPager->showNAV(); # show paging nav, only if enough records	 
        }else{#no records
            $myReturn .= "<div align=center>There are currently no responses to the survey!</div>";	
        }
    @mysqli_free_result($result);
        return $myReturn;
    }#end response list
}#end SurveyUtil class

