<h2>Change Timer</h2>
<form method="post" action="">
Start Date:<input id='dp1' name='start_dt' type="text"> Time:<input id='start_time' name='start_time' class='timepicker'/><br/>
End Date:<input id='dp2' name='end_dt' > Time:<input id='end_time' name='end_time' class='myclass timepicker'/><br/>
<input type="submit" value="Update Timer" name="update"/>
 </form>
<h2>Change Method</h2>
<form method="POST" action="">
    Method:<select name="type">
        <option value="1">Rely on Timer</option>
        <option value="1">Open</option>
        <option value="1">Closed</option>
    </select>
    
</form>
<script>
    $.datepicker.formatDate("yy-mm-dd");
      $(function() {
    $( "#dp1" ).datepicker({
        showButtonPanel: true,
        dateFormat: "yy-mm-dd"
    });
  });
$(function() {
    $( "#dp2" ).datepicker({
        showButtonPanel: true,
        dateFormat: "yy-mm-dd"
    });
  });
</script>
<!--<script>
$("#datepicker").kendoDatePicker({
    format: "yyyy-MM-dd"
});
$("#enddatepicker").kendoDatePicker({
    format: "yyyy-MM-dd"
});
</script>
-->