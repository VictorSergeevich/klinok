<?php
use core\Core as Core;

$res = Core::getElements();
//print_r($res);

?>
<table border="1" cellpadding="7" cellspacing="0" class="admin-table-users">
<? foreach ($res as $item) { ?>
	<tr>
		<td><?=$item["ID"];?></td>
		<td><?=$item["NAME"];?></td>
		<td><?=$item["TEXT"];?></td>
		<td><?=$item["IMG"];?></td>
	</tr>
<? } ?>
</table>