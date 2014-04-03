<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Science Olympiad Event Sign Up</title>

<link href="source/main.css" rel="stylesheet" type="text/css" />
<!-- Add the Kendo styles to the in the head of the page... -->
<link href="source/kendo.common.min.css" rel="stylesheet" />
<link href="source/kendo.kendo.min.css" rel="stylesheet" />
<link href="source/datepicker/css/datepicker.css" rel="stylesheet"/>
<script type="text/javascript" src="source/timepicker.js"></script>
<link rel="shortcut icon" href="source/images/favicon.ico" >
	 <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<!-- ...then paste the Kendo scripts in the page body (before using the framework) -->
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="source/kendo.all.min.js"></script>
<script src="source/jquery.jeditable.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript" >

$(document).ready(function() {
$('#drop_box').hide();
$('#hidden_teams').hide();
$('#drop_box_t').hide();
// toggles the slickbox on clicking the noted link �
$('#drop').click(function() {
	$('#drop_box').toggle(400);
	return false;
	});
// toggles the slickbox on clicking the noted link �
$('#hideteam').click(function() {
	$('#hidden_teams').toggle(400);
	return false;
	});
$('#drop_team').click(function() {
	$('#drop_box_t').toggle(400);
	return false;
	});
});
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}


function prepareInputsForHints() {
  var inputs = document.getElementsByTagName("input");
  for (var i=0; i<inputs.length; i++){
    inputs[i].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    inputs[i].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
  var selects = document.getElementsByTagName("select");
  for (var k=0; k<selects.length; k++){
    selects[k].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    selects[k].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
  var textareas = document.getElementsByTagName("textarea");
  for (var m=0; m<textareas.length; m++){
    textareas[m].onfocus = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
    }
    textareas[m].onblur = function () {
      this.parentNode.getElementsByTagName("span")[0].style.display = "none";
    }
  }
}
addLoadEvent(prepareInputsForHints);
$(function() {
  $(".edit").editable("updated_events.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      onblue:"submit",
      width : "500",
      loadtext  : 'Updating…'
  });
});
$(function() {
	
  $(".edit_time").editable("updated_times.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      onblue:"submit",
      width : "500",
      loadtext  : 'Updating…'
  });
});
$(function() {
  $(".teamedit").editable("update_users.php", { 
      indicator : "Updating...",
      submitdata: { _method: "put" },
      select : true,
      submit : 'Update',
      cssclass : "editable",
      onblue:"submit",
      width : "500",
      loadtext  : 'Updating…'
  });
});
</script>
</head>

<body>
	<div id="header">
    	<div class="logo"><img src="source/images/logo.png" border="0" alt="" title="" /></div>       
    </div>
<div id="main_body">

<div id="menu"><div id="spacer"></div>
<ul>
<?php $MVC->display_menu();//INSERT MENU?>
</ul>

           </div>
<div id="sep"></div>
<div id="page"><div id="content">