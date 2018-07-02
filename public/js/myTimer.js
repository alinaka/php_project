(function() {
    'use strict';
    
    
    $('.startButton').click(function(e) {
        var timer = new Timer();
        var target = e.target.nextElementSibling;
        timer.start();
        console.log(target);
        timer.addEventListener('secondsUpdated', function(e) {
            target.innerText = timer.getTimeValues().toString();
            $('#tracker').html(timer.getTimeValues().toString());
        });
        timer.addEventListener('started', function (e) {
            //стили - изменений иконки
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