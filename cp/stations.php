<?php
$query = $conn->query("SELECT
						`stations`.`id`,
						`stations`.`mac`,
						`locations`.`name` AS `location_name`,
						`station_data`.`datetime` AS `last_update`,
						CONCAT(
							IF (`stations`.`temperature`	= 1, 'Temperature, ',		''),
							IF (`stations`.`humidity`		= 1, 'Humidity, ',			''),
							IF (`stations`.`soilMoist`		= 1, 'Soil Moisture, ',		''),
							IF (`stations`.`phMeter`		= 1, 'pH Meter, ',			''),
							IF (`stations`.`wetLeaf`		= 1, 'Wet Leaf, ',			''),
							IF (`stations`.`windSpeed`		= 1, 'Wind Speed, ',		''),
							IF (`stations`.`windDir`		= 1, 'Wind Direction, ',	''),
							IF (`stations`.`rainMeter`		= 1, 'Rain Meter, ',		''),
							IF (`stations`.`solarRad`		= 1, 'Solar Radiation',		'')
						) AS `sensors`
						FROM `stations`
							INNER JOIN `locations`
								ON `stations`.`location_id` = `locations`.`id`
							LEFT JOIN `station_data`
								ON `station_data`.`station_id` = `stations`.`id`;");


$row = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<table class="table table-bordered table-responsive table-hover" id="stationsTable">
	<thead>
		<tr>
			<th>#</th>
			<th>MAC Address</th>
			<th>Location</th>
			<th width="40%">Sensors</th>
			<th>Last Update</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th colspan="5" class="ts-pager form-horizontal">
				<button type="button" class="btn first"><i class="icon-step-backward glyphicon glyphicon-step-backward"></i></button>
				<button type="button" class="btn prev"><i class="icon-arrow-left glyphicon glyphicon-backward"></i></button>
				<span class="pagedisplay"></span> <!-- this can be any element, including an input -->
				<button type="button" class="btn next"><i class="icon-arrow-right glyphicon glyphicon-forward"></i></button>
				<button type="button" class="btn last"><i class="icon-step-forward glyphicon glyphicon-step-forward"></i></button>
				<select class="pagesize input-mini" title="Select page size">
				  <option selected="selected" value="10">10</option>
				  <option value="25">25</option>
				  <option value="50">50</option>
				</select>
				<select class="pagenum input-mini" title="Select page number"></select>
			</th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		foreach ($row as $value) {
		?>
		<tr>
			<td><?php echo $value['id']; ?></td>
			<td><a href="?p=station&mac=<?php echo $value['mac']; ?>"><?php echo $value['mac']; ?></a></td>
			<td><?php echo $value['location_name']; ?></td>
			<td>
			<?php
			$sensors = explode(',', $value['sensors']);
			foreach ($sensors as $val) {
				echo '<span class="label label-default">' . trim($val) . '</span> ';
			}
			?>
			</td>
			<td><?php echo $value['last_update']; ?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

