<?php
  
  // Include database file
  include 'managers.php';
  $managerObj = new Employee();
  // Delete record from table
  if(isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
      $deleteId = $_GET['deleteId'];
      $managerObj->deleteRecord($deleteId);
  }
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sales Team App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>


<div class="container">
        <h2 class="text-center mt-5 mb-3">Laravel Project Manager</h2>
        <div class="card">
            <div class="card-header">
                <button class="btn btn-outline-primary" onclick="createProject()">
                    Create New Project
                </button>
            </div>
            <div class="card-body">
                <div id="alert-div">

                </div>
                < <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="bodyData">

                    </tbody>
                    </table>
            </div>
        </div>
    </div>


  <!-- modal for creating and editing function -->
  <div class="modal" tabindex="-1"  id="form-modal">
        <div class="modal-dialog" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Project Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="error-div"></div>
                <form>
                    <input type="hidden" name="update_id" id="update_id">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                    </div>
                 
                    <button type="submit" class="btn btn-outline-primary mt-3" id="save-project-btn">Save Project</button>
                </form>
            </div>
            </div>
        </div>
    </div>

       <!-- view record modal -->
       <div class="modal" tabindex="-1" id="view-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Project Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <b>Name:</b>
                    <p id="name-info"></p>
                    <b>Description:</b>
                    <p id="description-info"></p>
                </div>
            </div>
        </div>
    </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<script type="text/javascript">
        /*
                This function will get all the project records
            */
        showAllProjects();

        $.ajax({
    type: 'get',
    url: 'display.php',
 
    success: function(data) {
      //  alert(data);
    }
});

        function showAllProjects() {
       
            let url = $('meta[name=app-url]').attr("content") + "/projects";
            $.ajax({
                url: "display.php",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(data) {
                  console.log(data);
                //    console.log(dataResult);
                    var resultData = data;
                    var bodyData = '';
                    var i = 1;
                    let editBtn;
                    $.each(resultData, function(index, row) {
                        var editUrl = url + '/' + data.value + "/edit";
                        let showBtn = '<button ' +
                            ' class="btn btn-outline-success" ' +
                            ' onclick="showProject(' + row.id + ')">Show' +
                            '</button> ';

                        let editBtn = '<button ' +
                            ' class="btn btn-outline-success" ' +
                            ' onclick="editProject(' + row.id + ')">Edit' +
                            '</button> ';
                        let deleteBtn = '<button ' +
                            ' class="btn btn-outline-danger" ' +
                            ' onclick="destroyProject(' + row.id + ')">Delete' +
                            '</button>';

                        bodyData += "<tr>"
                        bodyData += "<td>" + i++ + "</td><td>" + row.name + "</td><td>" + row.email + "</td>" +
                            "<td>" + showBtn + editBtn + deleteBtn + "</td>"
                        bodyData += "</tr>";

                    })
                    $("#bodyData").append(bodyData);
                }
            });
        }


        /*
            check if form submitted is for creating or updating
        */
        $("#save-project-btn").click(function(event) {
            event.preventDefault();
            if ($("#update_id").val() == null || $("#update_id").val() == "") {
                storeProject();
            } else {
                updateProject();
            }
        })

        /*
            show modal for creating a record and 
            empty the values of form and remove existing alerts
        */
        function createProject() {
            $("#alert-div").html("");
            $("#error-div").html("");
            $("#update_id").val("");
            $("#name").val("");
            $("#description").val("");
            $("#form-modal").modal('show');
        }

        /*
            submit the form and will be stored to the database
        */
        function storeProject() {
            $("#save-project-btn").prop('disabled', true);
            let data = {
                name: $("#name").val(),
                description: $("#description").val(),
            };
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "route.php",
                type: "POST",
                data: data,
                success: function(response) {
                    $("#save-project-btn").prop('disabled', false);
                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>Project Created Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#name").val("");
                    $("#description").val("");
                    $("#bodyData").empty();
                    showAllProjects();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    $("#save-project-btn").prop('disabled', false);

                    /*
            show validation error
                        */
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        let errors = response.responseJSON.errors;
                        let descriptionValidation = "";
                        if (typeof errors.description !== 'undefined') {
                            descriptionValidation = '<li>' + errors.description[0] + '</li>';
                        }
                        let nameValidation = "";
                        if (typeof errors.name !== 'undefined') {
                            nameValidation = '<li>' + errors.name[0] + '</li>';
                        }

                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + nameValidation + descriptionValidation + '</ul>' +
                            '</div>';
                        $("#error-div").html(errorHtml);
                    }
                }
            });
        }
        /*
            edit record function
            it will get the existing value and show the project form
        */
        function editProject(id) {
            console.log(id);
          //  console.log(getid);
            $("#name-info").html("");
            $("#description-info").html("");
          //  urr = "infoEdit.php?id="+id;
         
            $.ajax({
                url: "infoEdit.php?id="+id,
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(info) {
                    console.log(info);
                  //  console.log(url);
                  $.each(info, function(index, row) {
                    $("#alert-div").html("");
                    $("#error-div").html("");
                    $("#update_id").val(row.id);
                    $("#name").val(row.name);
                    $("#description").val(row.email);
                    $("#form-modal").modal('show');
                  })
                },
                
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }

        /*
            sumbit the form and will update a record
        */
        function updateProject() {
            $("#save-project-btn").prop('disabled', true);
    
          //  console.log($("#update_id").val());
            let data = {
                _token: '{{ csrf_token() }}',
                id: $("#update_id").val(),
                name: $("#name").val(),
                description: $("#description").val(),
            };
            $.ajax({
                url: "route.php/?id=" + $("#update_id").val(),
                type: "POST",
                data: data,
                success: function(response) {
                  console.log(response);
                    $("#save-project-btn").prop('disabled', false);
                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>Project Updated Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#name").val("");
                    $("#description").val("");
                    $("#bodyData").empty();
                    showAllProjects();
                    $("#form-modal").modal('hide');
                },
                error: function(response) {
                    /*
            show validation error
                        */
                    $("#save-project-btn").prop('disabled', false);
                    if (typeof response.responseJSON.errors !== 'undefined') {
                        console.log(response)
                        let errors = response.responseJSON.errors;
                        let descriptionValidation = "";
                        if (typeof errors.description !== 'undefined') {
                            descriptionValidation = '<li>' + errors.description[0] + '</li>';
                        }
                        let nameValidation = "";
                        if (typeof errors.name !== 'undefined') {
                            nameValidation = '<li>' + errors.name[0] + '</li>';
                        }

                        let errorHtml = '<div class="alert alert-danger" role="alert">' +
                            '<b>Validation Error!</b>' +
                            '<ul>' + nameValidation + descriptionValidation + '</ul>' +
                            '</div>';
                        $("#error-div").html(errorHtml);
                    }
                }
            });
        }

        /*
            get and display the record info on modal
        */
        function showProject(id) {
         //  console.log(id+'text');
            $("#name-info").html("");
            $("#description-info").html("");
            $.ajax({
                url: "singleData.php",
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function(info) {
                  $.each(info, function(index, row) {
                    $("#name-info").html(row.name);
                    $("#description-info").html(row.email);
                    })
                    $("#view-modal").modal('show');
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }

        /*
            delete record function
        */
        function destroyProject(id) {
            let url = $('meta[name=app-url]').attr("content") + "/projects/" + id;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "delete.php?id=" + id,
                type: "DELETE",
                success: function(response) {
                    let successHtml =
                        '<div class="alert alert-success" role="alert"><b>Data Deleted Successfully</b></div>';
                    $("#alert-div").html(successHtml);
                    $("#bodyData").empty();
                    showAllProjects();
                },
                error: function(response) {
                    console.log(response.responseJSON)
                }
            });
        }
    </script>

