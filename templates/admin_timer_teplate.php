<h2>Change Timer</h2>
<form method="post" action="">
Start Date:<input id='dp1' name='start_dt' value=<?php $timer = new Timer; echo $timer->returnDate("start");?> type="text">
Time:<select name="st_hour">
<option value="01">01</option><option value="02">02</option>
<option value="03">03</option><option value="04">04</option>
<option value="05">05</option><option value="06">06</option>
<option value="07">07</option><option value="08">08</option>
<option value="09">09</option><option value="10">10</option>
<option value="11">11</option><option value="12">12</option>
<option value="13">13</option><option value="14">14</option>
<option value="15">15</option><option value="16">16</option>
<option value="17">17</option><option value="18">18</option>
<option value="19">19</option><option value="20">20</option>
<option value="21">21</option><option value="22">22</option>
<option value="23">23</option><option value="24">24</option>
</select>
<select name="st_min">
    <option value="00" selected=selected>00</option><option value="10">10</option>
    <option value="20">20</option>
    <option value="30">30</option><option value="40">40</option>
    <option value="50">50</option><option value="60">60</option>
</select>
<br/>
End Date:<input id='dp2' name='end_dt' value="<?php $timer = new Timer; echo $timer->returnDate("end");?>"type="text">
Time:<select name="end_hour">
<option value="01">01</option><option value="02">02</option>
<option value="03">03</option><option value="04">04</option>
<option value="05">05</option><option value="06">06</option>
<option value="07">07</option><option value="08">08</option>
<option value="09">09</option><option value="10">10</option>
<option value="11">11</option><option value="12">12</option>
<option value="13">13</option><option value="14">14</option>
<option value="15">15</option><option value="16">16</option>
<option value="17">17</option><option value="18">18</option>
<option value="19">19</option><option value="20">20</option>
<option value="21">21</option><option value="22">22</option>
<option value="23">23</option><option value="24">24</option>
</select>
<select name="end_min">
    <option value="00"  selected=selected>00</option><option value="10">10</option>
    <option value="20">20</option>
    <option value="30">30</option><option value="40">40</option>
    <option value="50">50</option><option value="60">60</option>
</select><br/>
<input type="submit" value="Update Timer" class="btn btn-primary" name="update"/>
 </form>
<h2>Change Method</h2>
<form method="POST" action="" class="form-inline">
    Method:<select name="type">
<?php $timer = new Timer; echo $timer->return_select_options();?>
    </select>
    <input type="submit" value="Change" class="btn btn-primary" name="change"/>
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
