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

function displayData(){
    var displayData="true";
    $.ajax({
        url:"display_data.php",
        type: 'post',
        data: {
            displaySend:displayData
        },
        success:function (data,status){
            console.log(data);
            $('#result').html(data);
        }
    });
}

function addEvent(id){

    $.ajax({
        url:"judgeEventActions.php",
        type: 'post',
        data: {
            add_event:id
        },
        success:function (data,status){
            console.log(data);
            $('#result').html(data);
        }
    });

}

function submitAdd(id){
    const button = document.querySelector('#closeAdd'+id);
    button.click();
    let selected = $('#selected_Event'+id).val();
    let judgeID = id;
    console.log(judgeID);
    $.ajax({
        url:"judgeEventActions.php",
        type: 'post',
        data: {
            selectedEvent:selected,
            selectedJudge:judgeID
        },
        success:function (data,status){
            console.log(data);
            $('#result').html(data);
        }
    });
}