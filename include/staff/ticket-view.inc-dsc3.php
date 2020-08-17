          <?php ?>
                    <form id="merge" action="tickets.php?id=<?php echo $ticket->getId(); ?>#mergeTicket" name="merge" method="post" enctype="multipart/form-data">
                         <?php csrf_token(); ?>
                        <input type="hidden" name="ticket_id" value="<?=$id?>">
                        <input type="hidden" name="a" value="mergeticket">
                           <select id="keepticket" name="keepticket">


                        <?
                        $sql = 'SELECT a.ticket_id, concat(a.number,": ",b.subject) as label FROM `ost_ticket` as a  inner join  ost_ticket__cdata '.
                               'as b on a.ticket_id = b.ticket_id inner join ost_user_email as c on (a.user_id = c.user_id) '.
                               'where c.address= (SELECT ab.address FROM ost_ticket AS aa INNER JOIN ost_user_email AS ab ON ( aa.user_id = ab.user_id )'.
                               'WHERE aa.ticket_id ='.$ticket->getId().') and a.status_id = 1  and a.ticket_id <> '.$ticket->getId().' order by `created` desc ';
                        $lookuptickets = db_query($sql);
                  while (list($ticket_id,$label) = db_fetch_row($lookuptickets)){
                                ?>

                                    <option value="<?=$ticket_id?>"><?=$label?></option>
                                <?
                                }?>



                    </select>

                            <div  style="margin-left: 50px; margin-top: 5px; margin-bottom: 10px;border: 0px;" align="left">
                                <input class="button" type='submit' value='Merge Tickets'/>
                                <input class="button" type='reset' value='Reset' />
                                <input class="button" type='button' value='Cancel' onClick="history.go(-1)" />
                            </div>
                        </p>
                    </form>


