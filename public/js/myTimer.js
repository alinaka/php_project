(function () {
    'use strict';


    var p = document.getElementById('dateTime');
    var h = document.getElementById('hours');
    var m = document.getElementById('minutes');
    var s = document.getElementById('seconds');

    //var timer = setInterval(showTime, 1000);

    function showTime() {
        date = new Timer();
        h.innerText = addZero(date.getHours()) + ':';
        m.innerText = addZero(date.getMinutes()) + ':';
        s.innerText = addZero(date.getSeconds());
    }

    var timer = new Timer();

    function func() {
        console.log(timer.getDifference());
    }

    setTimeout(func, 5000);

    function addZero(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function Timer() {
        this.hours = 0;
        this.minutes = 0;
        this.seconds = 0;
        this.startingDate = new Date();
        this.currentDate;

        this.toString = function () {

        }

        this.updateTimer = function () {
            var intervals = setInterval(this.getDifference(), 1000);
        }

        this.getDifference = function () {
            this.currentDate = new Date();
            return this.currentDate - this.startingDate;
        }
    }

}());