<?php
	
	function showStreamDatatableRow($stream, $number, $tr)
	{
		$id = $stream->id;
		if($tr) {
			echo "<tr id='stream-tr-$id'>";
		}
		
		?>
		<td id="stream-number-td-<?php echo $id ?>"><?php echo $number ?></td>
		<td id="stream-name-td-<?php echo $id ?>"><?php echo $stream->name ?></td>
		<td id="stream-datetime-td-<?php echo $id ?>"><?php echo $stream->datetime ?></td>
		<?php
	}
