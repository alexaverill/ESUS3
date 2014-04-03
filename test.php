<?php
$time='10:30-11:30';
$event='Robo Cross&$';
$test='""';
$mal="union select '1', concat(uname||'-'||passwd) as name, '1971-01-01', '0' from usertable;";
$input=$event;
        $output=filter_var($input,FILTER_SANITIZE_SPECIAL_CHARS);
        $output=filter_var($output,FILTER_SANITIZE_STRING);
        $output=strip_tags($output);
print $output;
function sant_string($input){
        //THis will make sure that input is only a string of characters or numbers.
        $output=filter_var($input,FILTER_SANITIZE_SPECIAL_CHARS);
        $output=filter_var($output,FILTER_SANITIZE_STRING);
        $output=stripcslashes($output);
        return $output;
    }
?>