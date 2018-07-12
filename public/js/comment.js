var timer = setInterval(get_comments, 1000);

function get_comments() {
    var req = new XMLHttpRequest();
    var date = new Date();
    var formattedDate = formatDate(date);

    var path = '/comment/update/';
    path += formattedDate;

    req.open("POST", path, true);
    req.onload = function (oEvent) {
        if (req.status == 200) {
            console.log("Ok!", req.responseText, path);
        } else {
            console.log("error!");
        }
    };
    req.send();
}

function formatDate(date) {
    var year = date.getFullYear();
    var month = date.getMonth() + 1;
    var day = date.getDate();
    var time = addZero(date.getHours()) + ':' + addZero(date.getMinutes()) + ':' + addZero(date.getSeconds());
    return year + '.' + month + '.' + day + '-' + time;
}

function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
