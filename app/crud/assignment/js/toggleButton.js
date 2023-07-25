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
            const judgeSwitch = $('#judgeSwitch'+judgeID+eventID);
            judgeSwitch.parent().removeClass('d-inline-block');
            judgeSwitch.parent().addClass('d-none');

            const spinner = $('#smSpinner'+judgeID+eventID);
            spinner.removeClass('d-none');
            spinner.addClass('d-inline-block');
        },
        success:function (data,status){
            $('#result').html(data);
            const judgeSwitch = $('#judgeSwitch'+judgeID+eventID);
            judgeSwitch.parent().removeClass('d-none');
            judgeSwitch.parent().addClass('d-inline-block');

            const spinner = $('#smSpinner'+judgeID+eventID);
            spinner.removeClass('d-inline-block');
            spinner.addClass('d-none');
        }
    });
}