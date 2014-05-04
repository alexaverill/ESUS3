<?php $MVC=new MVC();?>
<p>This page allows you to send teams their event times via the email that you have for them</p>
    <h2>Send Teams Their Times</h2>
    <?php echo $MVC->display_email_options(1);?>
    <h2>Send All Teams Their Times</h2>
    <form method="POST" action=""><input name="all_teams" type="submit" value="Send All Teams Times"/></form> 
   <h2>Send All Teams Their Passwords</h2>
   <h4>How your Excel sheet (.xls) should look: <a href="source/example.xls">Download Example</a></h4>
   <h4><a href="admin_em_example.php">Email Template</a></h4>
   <form enctype="multipart/form-data" action="" method="POST">
    Message:
    <br/><textarea name="message" id="emess" height="100px" width="15%"></textarea><br/><input type="hidden" name="MAX_FILE_SIZE" value="100000" />
    Choose a sheet to upload: <input name="uploadedfile" id="file" type="file" /><br/>
    <input type="submit" name="up" value="Send Bulk Passwords" />
    </form>
   <script> $(document).ready(function() {
       $("#file").kendoUpload();
   });
   </script>


    <h2>Announcements</h2>
    <p> Send an email announcement to all teams
    <form method="POST" action="">
    <textarea name="emessage" id="emess" height="100px" width="15%"></textarea><br/>
    <input name="send_ann" type="submit" value="Send Announcement"/>
    </form>
    <h2>Send Mail to a Team</h2>
    <?php echo $MVC->display_email_options(2);?>