<?php
if (isset($_SESSION['user']) && isset($_POST['comment'])) {
	$data = array(':user_id'	=> $_SESSION['user'],
				  ':feedback'	=> $_POST['feedback']);
	$query = $conn->prepare("INSERT INTO `feedbacks` (`user_id`,`feedback`) VALUES (:user_id, :feedback);");

	if ($query->execute($data)) {
	}
}
?>
<div class="row">
	<h2>Data for station #<?php echo $_GET['id'] ?></h2>
	<div class="col-md-10 col-sm-10">
		<div id="dow_chart" style="width:100%; height:350px;"></div>
	</div>
	<div class="col-md-2 col-sm-2">
		<input type=checkbox id=0 onClick="change(this)" checked>
		<label for="0"> Temperature</label><br />

		<input type=checkbox id=1 onClick="change(this)">
		<label for="1"> Solar Radiation</label><br />

		<input type=checkbox id=2 onClick="change(this)" checked>
		<label for="2"> Humidity</label><br />

		<input type=checkbox id=3 onClick="change(this)">
		<label for="3"> Rain Meter</label><br />

		<input type=checkbox id=4 onClick="change(this)">
		<label for="4"> Wet Leaf</label><br />

		<input type=checkbox id=5 onClick="change(this)">
		<label for="5"> Soil Moisture</label><br />

		<input type=checkbox id=6 onClick="change(this)">
		<label for="6"> pH Meter</label><br />

		<input type=checkbox id=7 onClick="change(this)">
		<label for="7"> Wind Speed</label><br />

		<hr />

		<small>
			- You can zoom by dragging on any part of the chart, horizontally or vertically.<br />
			- Double click to reset the zoom.
		</small>
	</div>
</div>

<br />
<br />
<br />


<div id="wind" style="min-width: 420px; max-width: 600px; height: 400px; margin: 0 auto"></div>

<div style="display:none">
	<table id="freq" border="0" cellspacing="0" cellpadding="0">
		<tr nowrap bgcolor="#CCCCFF">
			<th colspan="9" class="hdr">Table of Frequencies (percent)</th>
		</tr>
		<tr nowrap bgcolor="#CCCCFF">
			<th class="freq">Direction</th>
			<th class="freq">&lt; 0.5 m/s</th>
			<th class="freq">0.5-2 m/s</th>
			<th class="freq">2-4 m/s</th>
			<th class="freq">4-6 m/s</th>
			<th class="freq">6-8 m/s</th>
			<th class="freq">8-10 m/s</th>
			<th class="freq">&gt; 10 m/s</th>
			<th class="freq">Total</th>
		</tr>
		<tr nowrap>
			<td class="dir">N</td>
			<td class="data">1.81</td>
			<td class="data">1.78</td>
			<td class="data">0.16</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">3.75</td>
		</tr>
		<tr nowrap>
			<td class="dir">NE</td>
			<td class="data">0.82</td>
			<td class="data">0.82</td>
			<td class="data">0.07</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">1.71</td>
		</tr>
		<tr nowrap>
			<td class="dir">E</td>
			<td class="data">0.62</td>
			<td class="data">2.20</td>
			<td class="data">0.49</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">3.32</td>
		</tr>
		<tr nowrap>
			<td class="dir">SE</td>
			<td class="data">1.61</td>
			<td class="data">3.06</td>
			<td class="data">2.37</td>
			<td class="data">2.14</td>
			<td class="data">1.74</td>
			<td class="data">0.39</td>
			<td class="data">0.13</td>
			<td class="data">11.45</td>
		</tr>
		<tr nowrap>
			<td class="dir">S</td>
			<td class="data">2.66</td>
			<td class="data">4.74</td>
			<td class="data">0.43</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">7.83</td>
		</tr>
		<tr nowrap>
			<td class="dir">SW</td>
			<td class="data">2.53</td>
			<td class="data">4.01</td>
			<td class="data">1.22</td>
			<td class="data">0.49</td>
			<td class="data">0.13</td>
			<td class="data">0.00</td>
			<td class="data">0.00</td>
			<td class="data">8.39</td>
		</tr>
		<tr nowrap>
			<td class="dir">W</td>
			<td class="data">1.64</td>
			<td class="data">1.71</td>
			<td class="data">0.92</td>
			<td class="data">1.45</td>
			<td class="data">0.26</td>
			<td class="data">0.10</td>
			<td class="data">0.00</td>
			<td class="data">6.09</td>
		</tr>
		<tr nowrap>
			<td class="dir">NW</td>
			<td class="data">1.58</td>
			<td class="data">4.28</td>
			<td class="data">1.28</td>
			<td class="data">0.76</td>
			<td class="data">0.66</td>
			<td class="data">0.69</td>
			<td class="data">0.03</td>
			<td class="data">9.28</td>
		</tr>		
		<tr nowrap>
			<td class="totals">Total</td>
			<td class="totals">25.53</td>
			<td class="totals">44.54</td>
			<td class="totals">15.07</td>
			<td class="totals">8.52</td>
			<td class="totals">4.31</td>
			<td class="totals">1.81</td>
			<td class="totals">0.23</td>
			<td class="totals">&nbsp;</td>
		</tr>
	</table>
</div>

<?php
if (isset($_SESSION['user'])) {
?>
<br />
<hr />

<div class="row">
	<div class="col-md-10 col-sm-10 col-md-offset-1 col-sm-offset-1">
		<h2>User Comments</h2>

		<?php
		if (isset($_SESSION['user'])) {
		?>
		<div class="row">
			<form method="post">
				<div class="form-group">
					<textarea class="form-control" name="comment" placeholder="Comment.." cols="100" rows="5"></textarea>
				</div>
				<button type="submit" class="btn btn-primary pull-right">Send</button>
			</form>
		</div>
		<?php
		}
		?>
</div>

<?php
}
?>


<script type="text/javascript" src="./js/dygraph-combined.js"></script>


<script type="text/javascript">
agrometChart = new Dygraph(
	document.getElementById('dow_chart'),
	"station_data.php?id=<?php echo $_GET['id'] ?>",
	{
		showRoller: true,
		labelsKMB: true,
		rollPeriod: 7,
		visibility: [true, false, true, false, false, false, false, false],
		showRangeSelector: true
	}
);

function change(el) {
	agrometChart.setVisibility(el.id, el.checked);
}

</script>

