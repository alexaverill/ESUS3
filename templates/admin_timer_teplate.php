<h2>Change Timer</h2>
<form method="post" action="">
Start Date:<input id='datepicker' name='start_dt'  id="dpd1"> Time:<input id='start_time' name='start_time' class='timepicker'/><br/>
End Date:<input id='enddatepicker' name='end_dt'  id="dpd2"> Time:<input id='end_time' name='end_time' class='myclass timepicker'/><br/>
<input type="submit" value="Update Timer" name="update"/>
 </form>
<script>
$("#datepicker").kendoDatePicker({
    format: "yyyy-MM-dd"
});
$("#enddatepicker").kendoDatePicker({
    format: "yyyy-MM-dd"
});
</script>
