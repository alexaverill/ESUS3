<?php /*include('classes.php');*/ $MVC=new MVC();?>
<div id="columns">
    <div id="bulk">
      <h1>Create a New Installation</h1>
          <form name="passform" action="" method="post">
              <dl>
                <dt>
                  <label for="compname">Competion Name</label>
                </dt>
                <dd>
              <input type="text" name="compname"id="compname" size="25" /> <span class="hint">Southern California State</span>
                </dd>
                <dt>
                <label for="username">Administrator Username</label>
                </dt>
                <dd>
                <input type="text" name="username" id="username" size="25" /><span class="hint">CaliAdmin</span><br/>
                </dd>
                    <dt>
                                <label for="psw">Password</label>
                  </dt>
                  <dd>
                      <input type="text" name="passbox" id="psw" size="25"/><span class="hint">Something between 5-10 characters, 7 is a good choice.</span>
                  </dd>
                 <dt>
                      <label for="timezone">Timezone</label>
                 </dt>
                 <dd>
                     <select name="timezone">
                         <option value="America/New_York">Eastern Time</option>
                         <option value="America/Chicago" selected="selected">Central Time</option>
                         <option value="America/Denver">Mountain Time</option>
                         <option value="America/Los_Angeles">Pacific Time</option>
                     </select>
               </dd>
                <dt>   <label for="divB">Division B</label> </dt>
              <dd><input type="checkbox" name="divB" value="b"> </dd>
              <dt>  <label for="divC">Division C</label></dt>
              <dd><input type="checkbox" name="divC" value="c"></dd>
                <dt>
                      <label for="submit"></label>
                      </dt>
                      <dd>
                      <input type="submit" value="Add Competition" class="btn btn-primary" name="addcomp"/>
                      </dd>
              </dl>
          </form>

</div>
<div id="individual1">

    <h1>Modify Competition</h1>
    <?php
        //echo $MVC->display_competitions();
        //if(isset($_POST['remove'])){
        //}
    ?>
	<hr>
</div>
</div>
