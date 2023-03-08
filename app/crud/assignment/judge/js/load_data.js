$(document).ready(function(){
    $('#select').on('change', function(){
        let v = $('#result').innerText;
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

