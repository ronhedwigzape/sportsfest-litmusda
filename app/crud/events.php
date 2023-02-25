<?php

    require_once '../config/database.php';
    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

    <!-- For Icon -->
    <link rel="stylesheet" href="https://kit.fontawesome.com/3142f33457.css" crossorigin="anonymous">

    <title>CRUD</title>

  </head>
  <body>
    
     <!-- Modal -->
     <!-- ADD POP UP FORM (Bootstrap MODAL) -->
     <div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="events_operation.php" method="POST">

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category_ID</label>
                            <input type="number" min="3" max="5" name="category_id" id="category_id" class="form-control" placeholder="Select your Categories_ID 3(literary), 4(music) or 5(dance)" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" placeholder="Enter your Slug" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter your Title" autocomplete="off" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="events_operation.php" method="POST">

                    <div class="modal-body">
                    
                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label>Categories_ID</label>
                            <input type="number" min="3" max="5" name="category_id" id="category_id" class="form-control" placeholder="Select your Categories_ID 3(literary), 4(music) or 5(dance)" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter your Slug">
                        </div>

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter your Title">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- DELETE POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="events_operation.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_id">

                        <h4>Do you want to Delete this Event ??</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> NO </button>
                        <button type="submit" name="deletedata" class="btn btn-danger"> Yes !! Delete it. </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="container my-3">
        <div class="card">
            <div class="card-body">
                <h1 style="text-align:center;"><b> <u>Events</u> </b></h1>
                <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addmodal">ADD DATA</button>
                <div class="btn-group" role="group" aria-label="Go to">
                    <select onchange="window.location.href=this.value" class="btn btn-secondary">
                        <option selected value="categories.php">Go to...</option>
                        <option value="competitions.php">Competitions</option>
                        <option value="categories.php">Categories</option>
                    </select>
                </div>
                <?php
                    require_once '../config/database.php';
                    require_once '../models/Event.php';
                    
                    $events = Event::all();
                ?>
                <table id="datatableid" class="table table-bordered table-info table-hover" style="text-align:center;">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" style="display:none;">ID</th>
                            <th scope="col" style="display:none;">Categories_ID</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Title</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event) { ?>
                            <tr>
                                <td style="display:none;"><?php echo $event->getId(); ?></td>
                                <td style="display:none;"><?php echo $event->getCategoryId(); ?></td>
                                <td><?php echo $event->getSlug(); ?></td>
                                <td><?php echo $event->getTitle(); ?></td>
                                <td>
                                    <button type="button" class="btn btn-success editbtn"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" class="btn btn-danger deletebtn"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>                    
            </div>
        </div>
    </div>


    <!-- Bootstrap Javascript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>


    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <!-- For Icon -->
    <script src="https://kit.fontawesome.com/3142f33457.js" crossorigin="anonymous"></script>

    <script src="main.js"></script>

    <script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);
                $('#slug').val(data[2]);
                $('#title').val(data[3]);
            });
        });
    </script>

</body>
</html>
