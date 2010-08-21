var $countDownTimer = 0;
var $timer = false;
var $countDownTimerReset = 0;
var $countDownFunction = false;

function countDown() {
	if (!$countDownFunction) {
		return false;
	}
	$countDownTimer = $countDownTimer - 1;
	if ($countDownTimer == 0) {
		$countDownFunction();
	}
	setTimeout('countDown();', 1000);
	$timer.html($countDownTimer);
}
function resetCountDown() {
	$countDownTimer = $countDownTimerReset;
	$timer.html($countDownTimer);
}

jQuery(function(){
	$timer = jQuery('#timer');
	$countDownTimerReset = $timer.html();
	$countDownFunction = function() {
		window.location.href = $timer.attr('href');
	};
	resetCountDown();
	setTimeout('countDown();', 1000);
/*
	jQuery('*').click(function(){
		resetCountDown();
	});
*/
});
