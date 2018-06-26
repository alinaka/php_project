(function() {
    'use strict';
    
    
    $('.chrono .startButton').click(function (e) {
        var timer = new Timer();
        
        timer.start();
        
        timer.addEventListener('secondsUpdated', function (e) {
        $('#chrono .values').html(timer.getTimeValues().toString());
        });
        timer.addEventListener('started', function (e) {
            $('#chrono .values').html(timer.getTimeValues().toString());
        });
        timer.addEventListener('reset', function (e) {
            $('#chrono .values').html(timer.getTimeValues().toString());
        });

    });
    $('#chrono .pauseButton').click(function (e) {
        timer.pause();
    });
    $('#chrono .stopButton').click(function (e) {
        timer.stop();
    });
    $('#chrono .resetButton').click(function (e) {
        timer.reset();
    });
    
}());