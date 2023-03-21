
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

// function submitAdd(id){
//     console.log('aaaaaa');
//     const button = document.querySelector('#closeAdd'+id);
//     button.click();
//     let selected = $('#selected_Event'+id).val();
//     let addToggle = $('#addEventToggle').val();
//     $.ajax({
//         url:"judgeEventActions.php",
//         type: 'post',
//         data: {
//             selectedEvent:selected,
//             selectedJudge:judgeID
//         },
//         success:function (data,status){
//             $('#result').html(data);
//         }
//     });
// }

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





