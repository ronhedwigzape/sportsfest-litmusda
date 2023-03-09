function load(){
    $('#judgeDiv').css("background-color", "#2F4F4F");
    $('#judgeWord').css("color", "white")
    $('#technicalData').hide();
    $('#judgeData').show();
}

function judgeShow(){
    $('#judgeDiv').css("background-color", "#2F4F4F");
    $('#judgeWord').css("color", "white");
    $('#technicalDiv').css("background-color", "#F0FFF0");
    $('#technicalWord').css("color", "#2F4F4F");
    $('#technicalData').hide();
    $('#judgeData').show();
}

function technicalShow(){
    $('#judgeDiv').css("background-color", "#F0FFF0");
    $('#judgeWord').css("color", "#2F4F4F");
    $('#technicalDiv').css("background-color", "#2F4F4F");
    $('#technicalWord').css("color", "white");
    $('#technicalData').show();
    $('#judgeData').hide();
}
