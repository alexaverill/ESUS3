<h2>Change Timer</h2>
<form method="post" action="">
Start Date:<input id='dp1' name='start_dt' type="text"> Time:<input id='start_time' name='start_time' class='timepicker'/><br/>
End Date:<input id='dp2' name='end_dt' > Time:<input id='end_time' name='end_time' class='myclass timepicker'/><br/>
<input type="submit" value="Update Timer" name="update"/>
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