$(document).ready(function () {

    $('.viewbtn').on('click', function () {
        $('#viewmodal').modal('show');
        $.ajax({ //create an ajax request to display.php
            type: "GET",
            url: "display.php",
            dataType: "html", //expect html to be returned                
            success: function (response) {
                $("#responsecontainer").html(response);
                //alert(response);
            }
        });
    });

});


$(document).ready(function () {

    $('.deletebtn').on('click', function () {

        $('#deletemodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        console.log(data);

        $('#delete_id').val(data[0]);

    });
});


$(document).ready(function () {

    $('.editbtn').on('click', function () {

        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
            return $(this).text();
        }).get();

        console.log(data);

        $('#update_id').val(data[0]);
        $('#fname').val(data[1]);
        $('#lname').val(data[2]);
        $('#course').val(data[3]);
    });
});
