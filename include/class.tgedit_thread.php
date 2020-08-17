<?php
//edits are inserted into class.thread.php around line 1116

////////////////////////////////////////////////////////
// TG edit - add list off cc names to title if present
// if cc's are added using the manual cc box, we need some record of them.  This puts it in the list of notes within a thread'
        if ($_POST['carbon_copy'] != '') {
            $cc_string = 'CCs of this email sent to '.$_POST['carbon_copy'];
        }
// end TG edit /////////////////////////////////////////////
        
        

/////////////////////////////////////////////////////////////
// TG edit - special cases for updating owner of ticket based on if the ticket was initiated by an generic apa account like program or ceforms
            
    // Select from ost_ticket table to determine if ticket is owned by program inbox (ID 378) or CEForms (ID 2201) so we can make a decision about updating user
      $query = "SELECT * FROM ".TICKET_TABLE." where ticket_id=".$vars['ticketId']." ";
      $res=db_query($query);
      $current = db_fetch_array($res);  
                
    //IF owned by one of the special cases listed in the if statement, then update owner table and make a small internal note in the body of the post to identify the new ownwer
      if ( $current['user_id']  == '378' ||  $current['user_id'] == '2201') {
          
          // Find the new owner based on the $vars variable in class.thread.php
              $query2 = "SELECT * FROM `ost_user_email` WHERE `address` LIKE '".$vars['TGposterEmail']."' ";
              $res2=db_query($query2);
              $email_data = db_fetch_array($res2);            
          
          // Add some ownership text to the body
              if ($vars['TGposterEmail'] != '') {
                  $body = $body . '<br><br>Updated owner to:' . $poster . ' - ' . $vars['TGposterEmail'];            
              }
              //  $body = $body . '<br><br>Current:' . $current['user_id'] . '<br>User:' . $email_data['user_id'] . ' - ' . $poster . ' - ' . $vars['TGposterEmail'] . '<br>ticketId:' . $vars['ticketId'];
          
          //"ChangeOwner()ish" function as seen in scp/ticket and class.ticket for table ost_ticket.user_id if we know how the new user is
              if ($user_id != '' && $user_id != '0') {
                  $query3 = 'UPDATE '.TICKET_TABLE.' SET updated = NOW(), user_id = \''.$email_data['user_id'].'\' WHERE ticket_id = \''.$vars['ticketId'].'\' ';
                  $res3=db_query($query3);          
              }
      }     
// end TG edit /////////////////////////////////////////////



/////////////////////////////////////////////////////////////
// TG edit - if a direct assignment to a staff member via @<<name>>, then remove the @<<name>> from the subject for future communications
    // remove everything after the lsat occurate of @@ in the subject line
    $body_temp = str_replace("<br />"," ",$body);
    $body_temp = strip_tags($body_temp); // remove all the html elements if present
    if (strpos($body, '##') !== false) { //see if first character is an @
    
        // Find the details of the string in the temp variable
        $start_temp = strpos($body_temp, '##'); // find where the string starts in the temp variable
        $arr = explode(' ',trim($body_temp)); // find space after ## and assume it is the end of the username
        $string_to_remove = $arr[0]; // will print Test
        
        //Now replace in the real string
        $body = str_replace($string_to_remove,"",$body);
    };

// end TG edit /////////////////////////////////////////////


?>