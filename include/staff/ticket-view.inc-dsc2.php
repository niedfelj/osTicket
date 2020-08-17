<?php if( $threadTypes[$entry['thread_type']] != 'message') {  
      if( $entry['invtime'] > 0) {
?>
<tr>

<td colspan="2" class="thread-body" id="thread-id-<?php
                echo $entry['id']; ?>"><div><?php 
                echo sprintf(__('Date: %s'), $entry['invdate']); ?></div></td>

<td colspan="1" class="thread-body" id="thread-id-<?php
                echo $entry['id']; ?>"><div><?php
                echo sprintf(__('Hours: %s'), $entry['invtime']); ?></div></td>

<td colspan="1" class="thread-body" id="thread-id-<?php
                echo $entry['id']; ?>"><div><?php
                echo sprintf(__('Type: %s'), $entry['invtype']); ?></div></td>

</tr>

<?php } } ?>
