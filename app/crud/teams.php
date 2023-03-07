<?php

require_once '../config/database.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="logo.png">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="dist/bootstrap-4.2.1/css/bootstrap.min.css">

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
                        <h5 class="modal-title" id="exampleModalLabel">Add Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="teams_operation.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label> Name </label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your Name" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label> Color </label>
                                <input type="text" name="color" class="form-control" placeholder="Enter your Color" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Select an image file to upload.</small>
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
                        <h5 class="modal-title" id="exampleModalLabel"> Edit Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="teams_operation.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="hidden" name="update_id" id="update_id">
                            <div class="form-group">
                                <label> Name </label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your Name" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label> Color </label>
                                <input type="text" name="color" id="color" class="form-control" placeholder="Enter your Color" autocomplete="off" required>
                            </div>

                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Select an image file to upload.</small>
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
                        <h5 class="modal-title" id="exampleModalLabel"> Delete Data </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="teams_operation.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <h4> Do you want to Delete this Data ??</h4>
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
                    <h1 class="text-center"><b> <u>Teams</u> </b></h1>
                    <button type="button" class="btn btn-primary mr-3 my-3" data-toggle="modal" data-target="#addmodal">ADD DATA</button>
                    <div class="btn-group" role="group" aria-label="Go to">
                        <select onchange="window.location.href=this.value" class="btn btn-secondary">
                            <option selected value="">Go to...</option>
                            <option value="competitions.php">Competitions</option>
                            <option value="categories.php">Categories</option>
                            <option value="events.php">Events</option>
                            <option value="criteria.php">Criterion</option>
                            <option value="judges.php">Judges</option>
                            <option value="technicals.php">Technicals</option>
                        </select>
                    </div>
                    <?php
                        require_once '../models/Team.php';

                        $teams = Team::all();
                    ?>
                    <table id="datatableid" class="table table-bordered table-info table-hover text-center" >
                        <thead class="table-dark">
                        <tr>
                            <th scope="col" class="d-none">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Color</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Operations</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($teams as $team) { ?>
                            <tr>
                                <td class="d-none"><?php echo $team->getId(); ?></td>
                                <td><?php echo $team->getName(); ?></td>
                                <td><?php echo $team->getColor(); ?></td>
                                <td><?php echo '<img src="uploads/'.$team->getLogo().'" width="50"/>'; ?></td>
                                <td>
                                    <button type="button" class="btn btn-success editbtn"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" class="btn btn-danger deletebtn" data-id="<?php echo $team->getId(); ?>"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Bootstrap Javascript -->
        <script src="dist/ajax/libs/jquery-3.3.1/jquery.min.js"></script>
        <script src="dist/bootstrap-4.2.1/js/bootstrap.min.js"></script>

        <!-- For Icon -->
        <script src="dist/fontawesome/icon.js"></script>

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
                    $('#name').val(data[1]);
                    $('#color').val(data[2]);
                    $('#logo').val(data[3]);

                });
            });
        </script>
    </body>
</html>
