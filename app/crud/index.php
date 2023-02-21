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

                <form action="insertcode.php" method="POST">

                    <div class="modal-body">
                        <div class="form-group">
                            <label> Slug </label>
                            <input type="text" name="slug" class="form-control" placeholder="Enter your Slug" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label> Title </label>
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
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="updatecode.php" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> Slug </label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter your Slug">
                        </div>

                        <div class="form-group">
                            <label> Title </label>
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
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="deletecode.php" method="POST">

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
                <h1 style="text-align:center;"><b> Competitions </b></h1>
                <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target="#addmodal">ADD DATA</button>
                <?php
                    require_once '../config/database.php';
                    $db = mysqli_select_db($conn, 'sportsfest-litmusda');

                    $query = "SELECT * FROM competitions";
                    $query_run = mysqli_query($conn, $query);
                ?>
                <table id="datatableid" class="table table-bordered table-secondary table-hover" style="text-align:center;">
                    <thead class="bg-info">
                        <tr>
                            <th scope="col"> ID</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Title </th>
                            <th scope="col"> Operations </th>
                        </tr>
                    </thead>
                    <?php
                        if($query_run)
                        {
                            foreach($query_run as $row)
                            {
                                ?>
                                <tbody>
                                    <tr>
                                        <td> <?php echo $row['id']; ?> </td>
                                        <td> <?php echo $row['slug']; ?> </td>
                                        <td> <?php echo $row['title']; ?> </td>
                                        <td>
                                            <a href="categories.php"><button type="button" class="btn btn-info viewbtn"> VIEW </button></a>
                                            <button type="button" class="btn btn-success editbtn"> EDIT </button>
                                            <button type="button" class="btn btn-danger deletebtn"> DELETE </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <?php           
                        }
                            }
                        else {
                            echo "No Record Found";
                        }
                    ?>
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

    <script src="main.js"></script>

</body>
</html>
