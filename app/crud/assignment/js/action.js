
function remove(judge,event){
    const button = document.querySelector('#button'+event);
    button.click();
    $.ajax({
        url:"judgeEventActions.php",
        type: 'post',
        data:{
            judge_id: judge,
            event_id: event
        },
        success:function (data,status){
            $('#result').html(data);
        }
    });


}



function submitAdd(id){
    const button = document.querySelector('#closeAdd'+id);
    button.click();
    let addToggle = $('#addEventToggle').val();
    let selected = $('#selected_Event'+id).val();
    $.ajax({
        url:"judgeEventActions.php",
        type: 'post',
        data: {
            selectedEvent:selected,
            selectedJudge:id,
            toggleData:addToggle,
            beforeSend:function (){
                $('.bigSpinner').show();
            },
        },
        success:function (data,status){
            $('#result').html(data);
            $('.bigSpinner').hide();
        }
    });
}

function removeTech(tech,event){
    const button = document.querySelector('#buttonTech'+event);
    button.click();
    $.ajax({
        url:"techEventActions.php",
        type: 'post',
        data:{
            tech_id: tech,
            event_id: event
        },
        success:function (data,status){
            $('#technicalResult').html(data);
        }
    });

}

function submitAddTech(id){
    const button = document.querySelector('#closeAddTech'+id);
    button.click();
    let selected = $('#selected_EventTech'+id).val();
    let techID = id;
    $.ajax({
        url:"techEventActions.php",
        type: 'post',
        data: {
            selectedEvent:selected,
            selectedTech:techID
        },
        success:function (data,status){
            $('#technicalResult').html(data);
        }
    });
}

function toggleValue1(){
    let a = $('#addEventToggle').val();
    let b = $('#addEventToggle');
    if (a == "false"){
        b.val("true");
    }
    else if (a == "true"){
        b.val("false");
    }
    let c = $('#addEventToggle').val();
    $.ajax({
        url:"get_data.php",
        type: 'post',
        data: {
            toggleValue:c
        },
        beforeSend:function (){

        },
        success:function (data,status){
        }
    });

}

function toggleValue2(){
    let a = $('#addEventToggle').val();
    let b = $('#addEventToggle');
    if (a == "false"){
        b.val("true");
    }
    else if (a == "true"){
        b.val("false");
    }
    let c = $('#addEventToggle').val();
    $.ajax({
        url:"judgeEventActions.php",
        type: 'post',
        data: {
            toggleValue:c
        },
        success:function (data,status){
        }
    });
}





