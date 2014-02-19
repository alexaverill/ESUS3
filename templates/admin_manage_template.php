<?php include('../classes.php'); $MVC=new MVC();?>
<div id="columns">
    <div id="bulk">
        <h1>Add Users</h1>
        <h3>Upload Your List of Users (.xls format)</h3>
        How your Excel sheet (.xls) should look:
        <br/>
        <a href="source/example.xls">Download Example</a>
        
        <form enctype="multipart/form-data" action="" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="100000" />
            Choose a sheet to upload: <input name="uploadedfile" id="file" type="file" /><br/>
            <input type="submit" name="up" value="Upload File" />
        </form>
    <script> $(document).ready(function() {
       $("#file").kendoUpload();
   });
   </script>
<h3>Create a new user</h3>
    <form name="passform" action="" method="post">
        <dl>
          <dt>
            <label for="schoolname">School</label>
          </dt>
          <dd>
        <input type="text" name="schoolname"id="schoolname" size="25" /> <span class="hint">For example Kingwood Highschool</span>
          </dd>
          <dt>
          <label for="username">Username</label>
          </dt>
          <dd>
          <input type="text" name="username" id="username" size="25" /><span class="hint">For example kingwoodhs.</span><br/>
          </dd>
           <dt>
            <label for="email">Email</label>
           </dt>
           <dd>
        <input type="text" name="email" id="email" size="25"/>
        <span class="hint">example@example.com.</span><br/>
        </dd>
            <dt>
                        <label for="psw">Password</label>
          </dt>
          <dd>
          <input type="text" name="passbox" id="psw" size="25"/><span class="hint">Something between 5-10 characters, 7 is a good choice.</span>
          </dd>
          <dt>
                <label for="submit"></label>
                </dt>
                <dd>
                <input type="submit" class="myButton" value="Add user" name="adduser"/> 
                </dd>
        </dl>
    </form>
    <Br>
            <h2><a href="generate_users.php">Generate Usernames</a></h2> 
    <h2><a href="password_generate.php">Generate Passwords</a></h2>
</div>
    
<div id="individual1">

    <h1>Modify Users</h1>
    <h2>Reset Password</h2>
    <?php
        echo $MVC->display_reset_password();
        ?>
    <h2>Edit Teams</h2>
            <?php
        echo $MVC->display_edit_teams();
        ?>
    <h2>Add Admin</h2>
    	<form method="POST" action="">
	Admin Username:<input type="text" name="username"/><br/>
	Admin Password:<input type="text" name="passbox"/><br/><input type="submit" name="add_admin" class="myButton" value="Add Admin"/>
	</form>
</div>
