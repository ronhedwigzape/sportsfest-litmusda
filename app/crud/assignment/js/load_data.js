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
                success: function(response){
                    $('#result').html(response);
                }
            });
        }
        else{
            $('#result').html('');
        }
    });
});



