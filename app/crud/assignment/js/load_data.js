$(document).ready(function(){

    $('#selectTech').on('change', function(){
        var optionValue = $(this).val();
        if(optionValue != ''){
            $.ajax({
                url: 'tech_data.php',
                type: 'POST',
                data: 'option=' + optionValue,
                success: function(response){
                    $('#technicalResult').html(response);
                }
            });
        }
        else{
            $('#technicalResult').html('');
        }
    });

    $('#select').on('change', function(){
        var optionValue = $(this).val();
        if(optionValue != ''){
            $.ajax({
                url: 'get_data.php',
                type: 'POST',
                data: 'option=' + optionValue,
                beforeSend:function (){
                    $('.spinner-border').show();
                    $('#result').hide();
                },
                success: function(response){
                    $('#result').html(response);
                    $('.spinner-border').hide();
                    $('#result').show();
                }
            });
        }
        else{
            $('#result').html('');
        }
    });
});




