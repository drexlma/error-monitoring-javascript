<?php 
opcache_reset();
if (PHP_SAPI === 'cli')
{
	    $_POST['pass'] = $_SERVER['argv'][1];
}
if(isset($_POST['pass']) ){
	    
	    if($_POST['pass'] == 'xxxxs'){
		            session_start();
			            $_SESSION['loggin'] = time();
			            echo 'ok';
				        }else {
						        echo 'pw?';
							    }
}

if(empty($_SESSION['loggin'])){
	    ?>
<form method="POST">
	<input type="password" name="pass">
	<input type="submit">

</form>    
    
<?php 
	    exit;
}

ini_set('memory_limit', '900M');



$errorcount = array();

$basedir = __dir__.'/../logs/'.date('Y.m.d').'/';
$errors = array();
$errors_messages = array();
foreach (glob($basedir."*.log") as $filename) {

	$logfile_raw = file_get_contents($filename);
	$logfile = json_decode($logfile_raw,true);
	$error = array();
	if(!empty($logfile['POST'])){
		$error['type'] = 'post';
		$log = json_decode($logfile['POST']['post'],true);
	} else {
		$error['type'] = 'get';
		$log = $logfile['GET'];        
	}
	$error['date'] = date('d.m.Y H:i:s',$logfile['date']);

	$error['message'] = $log['message'];

	$error['source'] = $log['source'];
	$error['lineno'] = $log['lineno'];
	$error['colno'] = $log['colno'];
	$error['exception'] = $log['exception'];
	#$error['raw'] = '<div class="ui button">Show flowing popup</div>
	#    <div class="ui flowing popup top left transition hidden">'.$logfile_raw.'</div>';


	$errorcount[md5($error['message'])]++;
	$errors[] = $error;
	$errors_messages[$error['message']][$error['source']] = true;
}

$errors = array_reverse($errors);
?>
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
	    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
	      crossorigin="anonymous"></script>
	      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<h1>Error monitoring</h1>
Einträge: <?php echo count($errors);?> <br>
Message: <?php echo count($errors_messages);?> <br>

<h2>Top Fehlermeldungen</h2>
<table class="ui celled padded table">
<tr><th>Message</th><th>Verschiedene Dateien</th><th>Anzahl</th></tr>
<?php

    foreach ($errors_messages as $message => $row) {
        echo '<tr>';
            echo "<td>".htmlspecialchars($message).	"</td>";
            echo "<td>".count($row).	"</td>";
            echo "<td>".$errorcount[md5($message)]."</td>";
        
        echo '</tr>';
    
    }
?>
</table>

<h2>Letzten 200 Einträge</h2>
<table class="ui celled padded table">
<tr><th>Typ</th><th>Datum</th><th>Message</th><th>Quelle</th><th>Line</th><th>Col</th><th>Exception</th><th>Anzahl</th></tr>
<?php
	$i = 0;
    foreach ($errors as $row) {
    
        	++$i;
        	if($i > 200){
        		continue;
        	}
        echo '<tr>';
        foreach ($row as $cell) {
            echo "<td>".htmlspecialchars($cell).	"</td>";
        }
            echo "<td>".$errorcount[md5($row['message'])]."</td>";
        
        
        echo '</tr>';			
    }
?></table>