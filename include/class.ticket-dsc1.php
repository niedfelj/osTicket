<?php

    //merge this ticket to another ticket
        global $thisuser;

        // update these tables...:
        // ost_ticket_attachment
        $sql1= 'UPDATE ost_ticket_attachment SET  '.
                ' ticket_id='.db_input(Format::striptags($keepticket)).
		' WHERE '.
                'ticket_id='.db_input($this->getId());
        // ost_ticket_thread
        $sql2= 'UPDATE ost_ticket_thread SET  '.
                ' ticket_id='.db_input(Format::striptags($keepticket)).
		' WHERE '.
                'ticket_id='.db_input($this->getId());
        // ost_ticket_note
//        $sql3= 'UPDATE ost_ticket_note SET  '.
//                ' ticket_id='.db_input(Format::striptags($keepticket)).
//                ' WHERE '.
//                'ticket_id='.db_input($this->getId());
        // ost_ticket_response
//        $sql4= 'UPDATE ost_ticket_response SET  '.
//                ' ticket_id='.db_input(Format::striptags($keepticket)).
//                ' WHERE '.
//                'ticket_id='.db_input($this->getId());

        // create message on this ticket about merge (ost_ticket_message)
        $sql5= 'INSERT INTO ost_ticket_thread SET  '.
                ' ticket_id='.db_input($this->getId()).
                ', source="Web"'.
                ', created=NOW()'.
                ', thread_type="M"'.
                ', poster="SYSTEM"'.
                ', body=CONCAT("Merged with ticket ",'.
                '  ( SELECT number from ost_ticket where ticket_id='.db_input(Format::striptags($keepticket)).' ))'.
                ';';

        // set updated and created tags to the latest / earliest of the tickets respectively on remaining ticket 
        $sql6= 'UPDATE ost_ticket SET  '.
                ' created = (select created from '.
                ' (SELECT IF(a.created<b.created,a.created,b.created) as created FROM ost_ticket as a join ost_ticket as b where '.
                ' a.ticket_id='.db_input(Format::striptags($keepticket)).
                ' AND '.
                ' b.ticket_id='.db_input($this->getId()).
                ' ) as x)'.
                ' ,updated= (select updated from '.
                ' (SELECT IF(a.updated>b.updated,a.updated,b.updated) as updated FROM ost_ticket as a join ost_ticket as b where '.
                ' a.ticket_id='.db_input(Format::striptags($keepticket)).
                ' AND '.
                ' b.ticket_id='.db_input($this->getId()).
                ' ) as y)'.
		' WHERE '.
                ' ticket_id='.db_input(Format::striptags($keepticket));

        // close and unassign this ticket (ost_ticket)
        $sql= 'UPDATE ost_ticket SET  '.
                ' staff_id = 0'.
                ' ,status_id = 3'.
                ' ,updated=NOW()'.
                ' ,closed=NOW()'.
		' WHERE '.
                'ticket_id='.db_input($this->getId());


//        echo $sql1;
//        echo $sql2;
//        echo $sql3;
//        echo $sql4;
//        echo $sql5;
//        echo $sql6;
//        echo $sql;
  
          db_query($sql1);
          db_query($sql2);
          db_query($sql5);
          db_query($sql6);
          db_query($sql);
return 1;
?>
