<?php 
            $fields=array();
echo  $ticket->mergeTicket($_POST['keepticket']);
//            if( $ticket->mergeTicket($_POST['keepticket'])==1){
//                //Send out alerts??
                $title='Merged Tickets';
                $msg='Ticket Updated Sucessfully';
//            }else{
//                $errors['err']=$errors['err']?$errors['err']:'Unable to merge tickets';
//            }

?>
