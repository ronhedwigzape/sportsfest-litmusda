function judgeToggle(judgeID,eventID){
    let toggleID = $('#judgeSwitch'+judgeID+eventID).val();

    let judge_num = judgeID;
    let event_num = eventID;

    $.ajax({
        url:"judgeEventActions.php",
        type: 'post',
        data: {
            judgeNum:judge_num,
            eventNum:event_num,
            toggle_id:toggleID
        },
        beforeSend:function (){
            $('#judgeSwitch'+judgeID+eventID).hide();
            $('#smSpinner'+judgeID+eventID).show();
        },
        success:function (data,status){
            $('#result').html(data);
            $('#judgeSwitch'+judgeID+eventID).show();
            $('#smSpinner'+judgeID+eventID).hide();
        }
    });

}