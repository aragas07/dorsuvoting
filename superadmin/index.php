<?php 
    include ("../db/DBConnection.php");
    global $conn;
    session_start();
    if(!$_SESSION['admin']){
        header('location:../login.html');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Super admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#" id="logout">Logout</a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar elevation-4 sidebar-light-primary">
            <a href="index3.html" class="brand-link navbar-primary">
                <img src="../dist/img/credit/dorsu.png" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text" style="font-weight: 600; color: white">DOrSU Voting</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-a active">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p class="text">Student</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-a">
                                <i class="nav-icon fas fa-fingerprint"></i>
                                <p class="text">Open Election</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-a">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link nav-a">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>Add</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <?php include('student.php');
                 include('election.php');
                 include('admin.php');
                 include('addstudent.php');?>
            </div>
        </div>
        <!-- /.control-sidebar -->
    </div>
    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../plugins/chart.js/Chart.min.js"></script>
    <script src="../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrxaap-4.min.js"></script>
    <script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="../dist/js/adminlte.js"></script>
    <script src="../dist/js/pages/dashboard.js"></script>
    <script src="../dist/js/demo.js"></script>
    <script src="../dist/js/swal.min.js"></script>

    <script>
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms)
                .forEach(function(form) {form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        $(document).ready(function(){
            $("#open_elect").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: '../db/DBManipulation.php',
                    type: 'post',
                    data: new FormData(this),
                    contentType:false,
                    cache: false,
                    processData: false,
                    success: function(result){
                        console.log(result);
                        if(result){
                            Swal.fire('This year election was successful in craeting.','','success');
                            loadElectTable();
                        }else{
                            Swal.fire('Sorry.','','error');
                        }
                    },error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                })
            })

            $("#forms").on('submit',function(event){
                event.preventDefault();
                var b=true;
                $(".inp-ad").each(function(){
                    if($(this).val().trim() == ''){
                        b=false;
                    }
                })
                if(b){
                    $.ajax({
                        url: '../db/DBManipulation.php',
                        type: 'post',
                        data: new FormData(this),
                        contentType:false,
                        cache: false,
                        processData: false,
                        success: function(result){
                            if(result == 'success'){                            
                                Swal.fire('Successfully to add a new admin.','','success');
                                loadAdmin();
                                $("#modal-default").modal('hide');
                            }else{Swal.fire('Sorry!!!','','error');}
                        }
                    })
                }
            })
            loadElectTable();
            function loadElectTable(){
                $.ajax({
                    url: '../db/DBManipulation.php',
                    type: 'post',
                    data: {electtable: true},
                    success: function(result){
                        $("#election-table-body").html(result);
                    }
                })
            }

            $("#importdata").on('submit',function(event){
                event.preventDefault();
                $.ajax({
                    url: '../db/import.php',
                    method: 'POST',
                    data: new FormData(this),
                    contentType:false,
                    cache: false,
                    processData: false,
                    success: function(result){
                        swal.fire('Successfully to insert','', 'success');
                        $("#chfile").val("");
                    }
                })
            })

            $("#logout").click(function(){
                $.ajax({
                    url: '../db/DBManipulation.php',
                    type: 'post',
                    data: {logout: true},
                    success: function(result){
                        if(result == 'false') window.location = '../login.html';
                    }
                })
            })
            $("#institute").change(function(){
                paging('',$(this).val(),1);
                getStudent($("#search").val(),1,$(this).val());
                comelec($(this).val());
            })

            comelec($("#institute").val());
            paging('',$("#institute").val(),1);
            getStudent('',1,$("#institute").val());
            loadAdmin();
            function comelec(text){
                $.ajax({
                    url: '../db/DBManipulation.php',
                    type: 'post',
                    data: {getComelec: text},
                    success: function(result){
                        $("#comtable").html(result);
                        $(".stud-delete").click(function(){
                            Swal.fire({
                                title: 'Do you really want to remove this person from the committee.',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Yes',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: '../db/DBManipulation.php',
                                        type: 'post',
                                        data: {dropcom: $(this).attr('id')},
                                        success: function(result){
                                            if(result == 'true') {
                                                Swal.fire('Successfully to remove this person as a committee.', '', 'success');
                                                comelec($("#institute").val());
                                                getStudent($("#search").val(),1,$("#institute").val());
                                            }
                                        }
                                    })
                                } else if (result.isDenied) {
                                    Swal.fire('Changes are not saved', '', 'info')
                                }
                            })
                        })
                    }
                })
            }
            function paging(search,institute,id){
                $.ajax({
                    url: '../db/DBManipulation.php',
                    type: 'post',
                    data: {subjectpaging: id, institute: institute, searching: search},
                    success: function(result){
                        $("#paging").html(result);
                        $(".page-link").click(function(){
                            var chunk = $(this).attr('class').split(" ");
                            paging($("#search").val(),$("#institute").val(),chunk[1]);
                            getStudent($("#search").val(),chunk[1],$("#institute").val());
                        })
                    }
                })
            }
            $("#search").keyup(function(){                            
                getStudent($(this).val(),1,$("#institute").val());
                paging($(this).val(),$("#institute").val(),1);
            })

            function getStudent(search,page,institute){
                $.ajax({
                    url: '../db/DBManipulation.php',
                    type: 'post',
                    data: {getStudent: search, page: page, institute: institute},
                    success: function(result){
                        $("#studtable").html(result);
                        $(".select").click(function(){
                            Swal.fire({
                                title: 'Are you sure for this person to make a committee.',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Yes',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: '../db/DBManipulation.php',
                                        type: 'post',
                                        data: {createcom: $(this).attr('id')},
                                        success: function(result){
                                            if(result == 'true') {
                                                Swal.fire('Successfully to make this person as a committee.', '', 'success');
                                                comelec($("#institute").val());
                                                getStudent(search,page,institute);
                                            }
                                        }
                                    })
                                } else if (result.isDenied) {
                                    Swal.fire('Changes are not saved', '', 'info')
                                }
                            })
                        })
                    }
                })
            }

            $(".nav-a").each(function(index){
                $(this).click(function(){
                    $(".nav-a").each(function(ind){
                        $(this).attr('class','nav-link nav-a');
                        $(".hdn-div").eq(ind).attr('hidden', true);
                    });
                    $(this).attr('class','nav-link nav-a active');
                    $(".hdn-div").eq(index).attr('hidden', false);
                })
            })

            function loadAdmin(){
                $.ajax({
                    url: '../db/DBManipulation.php',
                    type: 'post',
                    data: {loadadmin: true},
                    success: function(result){
                        $("#admintable").html(result);
                        $(".admin-delete").click(function(){
                            Swal.fire({
                                title: 'Do you really want to remove this person.',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Yes',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: '../db/DBManipulation.php',
                                        type: 'post',
                                        data: {deleteadmin: $(this).attr('id')},
                                        success: function(result){
                                            if(result.trim() == 'true') {
                                                Swal.fire('Successfully to remove this person.', '', 'success');
                                                loadAdmin();
                                            }else{Swal.fire('Sorry!','','error');}
                                        }
                                    })
                                } else if (result.isDenied) {
                                    Swal.fire('Changes are not saved', '', 'info')
                                }
                            })
                        })
                    }
                })
            }
            
        })
    </script>
</body>

</html>