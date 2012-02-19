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
	<h2>Runs</h2>
	<table>
		<thead>
			<tr><th>Run #:</th><th>Output:</th><th>Answer:</th><th>Adjustments:</th><th>Execution time:</th></tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
<div class="right">
	<p>&nbsp;</p>
	<h2>Stats</h2>
	<h3>Avarage of 10 runs:</h3>
	<div class="stats">
		
	</div>
	<p>&nbsp;</p>
	<div class="avarage">
	
	</div>
	<p>&nbsp;</p>
	<h2>Numbers:</h2>
	<div>
		<p>1: <span class="one"></span></p>
		<p>2: <span class="two"></span></p>
		<p>3: <span class="three"></span></p>
		<p>4: <span class="four"></span></p>
		<p>5: <span class="five"></span></p>
		<p>6: <span class="six"></span></p>
		<p>7: <span class="seven"></span></p>
		<p>8: <span class="eight"></span></p>
		<p>9: <span class="nine"></span></p>
		<p>0: <span class="ten"></span></p>
	</div>
</div>
</body>
</html>
<script type="text/javascript">
var started = false;
var ready = true;

getRuns();

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
		$('table tbody').prepend('<tr class="running"><td colspan="5">Running...</td></tr>');
		$.get('training.php', function(data){
			$('table tbody tr.running').remove();
			if(data.run.output == data.run.answer){
				var corr = ' class="correct"';
			} else {
				var corr = ' class="incorrect"';
			}
			$('table tbody').prepend('<tr'+corr+'><td>'+data.run.run+'</td><td>'+data.run.output+'</td><td class="answer">'+data.run.answer+'</td><td>'+data.run.adjustments+'</td><td>'+data.time+'</td></tr>');
			ready = true;
			avarage10();
		}, 'json');
	}
}

function getRuns(){
	ready = false;
	$('table tbody').prepend('<tr class="running"><td colspan="5">Loading...</td></tr>');
	$.get('runs.php', function(data){
		$('table tbody tr.running').remove();
		$.each(data, function(index, value){
			if(value.output == value.answer){
				var corr = ' class="correct"';
			} else {
				var corr = ' class="incorrect"';
			}
			$('table tbody').prepend('<tr'+corr+'><td>'+value.run+'</td><td>'+value.output+'</td><td class="answer">'+value.answer+'</td><td>'+value.adjustments+'</td><td>&nbsp;</td></tr>');
		});
		ready = true;
		avarage10();
	}, 'json');
}

function avarage10(){
	var ones = 0;
	var twos = 0;
	var tres = 0;
	var fors = 0;
	var fivs = 0;
	var sixs = 0;
	var sevs = 0;
	var eits = 0;
	var nins = 0;
	var tens = 0;
	
	var count1 = 0;
	var count2 = 0;
	var count3 = 0;
	var count4 = 0;
	var count5 = 0;
	var count6 = 0;
	var count7 = 0;
	var count8 = 0;
	var count9 = 0;
	var count0 = 0;

	var av10 = 0;
	var count = 0;
	var correct = 0;
	$('.stats').html('');
	$.each($('table tbody tr').get().reverse(), function(index, row){
		count++;
		var ans = $(row).find('.answer').html();
		var answer = parseFloat(ans);
		switch(answer){
			case 1: count1++; break;
			case 2: count2++; break;
			case 3: count3++; break;
			case 4: count4++; break;
			case 5: count5++; break;
			case 6: count6++; break;
			case 7: count7++; break;
			case 8: count8++; break;
			case 9: count9++; break;
			case 0: count0++; break;
		}
		if($(row).hasClass('correct')){
			switch(answer){
				case 1: ones++; break;
				case 2: twos++; break;
				case 3: tres++; break;
				case 4: fors++; break;
				case 5: fivs++; break;
				case 6: sixs++; break;
				case 7: sevs++; break;
				case 8: eits++; break;
				case 9: nins++; break;
				case 0: tens++; break;
			}
			correct++;
			av10++;
		}
		if(count % 10 == 0){
			$('.stats').prepend('<p>'+av10+' correct = '+av10*10+'%</p>');
			av10 = 0;
		}
	});
	var av = (100 / count) * correct;
	$('.avarage').html('<p>Total avarage: '+Math.round(av)+'%</p>');
	
	$('span.one').html('correct: '+ones+' - '+Math.round((100 / count1) * ones) + '% in '+ count1 +' runs');
	$('span.two').html('correct: '+twos+' - '+Math.round((100 / count2) * twos) + '% in '+ count2 +' runs');
	$('span.three').html('correct: '+tres+' - '+Math.round((100 / count3) * tres) + '% in '+ count3 +' runs');
	$('span.four').html('correct: '+fors+' - '+Math.round((100 / count4) * fors) + '% in '+ count4 +' runs');
	$('span.five').html('correct: '+fivs+' - '+Math.round((100 / count5) * fivs) + '% in '+ count5 +' runs');
	$('span.six').html('correct: '+sixs+' - '+Math.round((100 / count6) * sixs) + '% in '+ count6 +' runs');
	$('span.seven').html('correct: '+sevs+' - '+Math.round((100 / count7) * sevs) + '% in '+ count7 +' runs');
	$('span.eight').html('correct: '+eits+' - '+Math.round((100 / count8) * eits) + '% in '+ count8 +' runs');
	$('span.nine').html('correct: '+nins+' - '+Math.round((100 / count9) * nins) + '% in '+ count9 +' runs');
	$('span.ten').html('correct: '+tens+' - '+Math.round((100 / count0) * tens) + '% in '+ count0 +' runs');
}
</script>