<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Train</title>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<style type="text/css">
* { margin:0; padding:0; }
html { font:62.5% "Courier New", Courier, monospace, sans-serif; }
body { font-size:1.2em; padding:1em; }
table { text-align:left; border-collapse:collapse; }
table th, table td { padding:0.2em 0.5em; border-bottom:1px solid #ddd; font-weight:normal; }
table tr.correct td { color:#009900; border-bottom:1px solid #fff; background:#eeffee; }
table tr.incorrect td { color:#ee0000; border-bottom:1px solid #fff; background:#ffeeee; }
table th, h3 { font-weight:bold; font-size:1.1em; }
.left, .right { float:left; margin:0 2em 0 0; }
</style>
</head>
<body>
<div class="left">
	<a href="" class="start">start</a> / <a href="" class="pauze">pauze</a>
	<h2>Runs - <span></span>% correct</h2>
	<table>
		<thead>
			<tr><th>Output:</th><th>Answer:</th></tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
</body>
</html>
<script type="text/javascript">
var started = false;
var ready = true;

window.setInterval(testCase, 100);

$('a.start').bind('click', function(e){
	e.preventDefault();
	started = true;
});

$('a.pauze').bind('click', function(e){
	e.preventDefault();
	$('table tbody tr.running td').html('Stopping...');
	started = false;
});

function testCase(){
	if(ready && started){
		ready = false;
		$('table tbody').prepend('<tr class="running"><td colspan="2">Running...</td></tr>');
		$.get('testing.php', function(data){
			$('table tbody tr.running').remove();
			if(data.output == data.answer){
				var corr = ' class="correct"';
			} else {
				var corr = ' class="incorrect"';
			}
			$('table tbody').prepend('<tr'+corr+'><td>'+data.output+'</td><td class="answer">'+data.answer+'</td></tr>');
			ready = true;
			correct();
		}, 'json');
	}
}

function correct(){
	var count = 0;
	var correct = 0;
	$.each($('table tbody tr').get().reverse(), function(index, row){
		count++;
		if($(row).hasClass('correct')){
			correct++;
		}
	});
	var av = (100 / count) * correct;
	$('h2 span').html(Math.round(av));
}
</script>