<?php
    include('DBConnection.php');
    global $conn;
    session_start();
    if(isset($_POST['login'])){
        $user = $_POST['login'];
        $pass = $_POST['password'];
        $qualified = 0;
        $commentText = '';
        $admin = $conn->query("SELECT * FROM admin WHERE username='$user' AND password='$pass'");
        $count = $conn->query("SELECT *,course.id AS cid, institute.id AS iid FROM institute INNER JOIN course INNER JOIN student ON course.id = student.course_id AND institute.id = course.institute_id WHERE student.id = '$user' AND birth = '$pass'");
        if($count->num_rows > 0){
            while($row = $count->fetch_assoc()){
                $_SESSION['status'] = $row['status'];
                $auth = '';
                $candidate = $conn->query("SELECT * FROM candidate WHERE approved = 1 AND student_id = '".$row['id']."'");
                if($candidate->num_rows > 0){
                    while($cand = $candidate->fetch_assoc()){
                        echo 'candidate';
                        $auth = 'candidate';
                    }
                }else if($row['status'] == 0){
                    echo 'chairman';
                }else{
                    $getComment = $conn->query("SELECT * FROM candidate WHERE approved = 2 AND student_id = '".$row['id']."'");
                    if($getComment->num_rows > 0){
                        $qualified = 1;
                        while($comment = $getComment->fetch_assoc()){
                            $commentText = $comment['comment'];
                        }
                    }
                    echo 'student';
                    $auth = 'student';
                }
                $_SESSION['auth'] = $auth.'||'.$row['id'].'||'.$row['profile'].'||'.$row['fname'].'||'.$row['mname'].'||'.$row['lname'].'||'.
                $row['birth'].'||'.$row['gpa'].'||'.$row['affiliation'].'||'.$row['year'].'||'.$row['status'].'||'.$row['course_name'].'||'.
                $row['email'].'||'.$row['contact'].'||'.$row['cid'].'||'.$row['name'].'||'.$row['iid'].'||'.$qualified.'||'.$commentText;
                
            }
        }else if($admin->num_rows > 0){
            echo 'admin';
            $_SESSION['admin'] = true;
        }else{
            echo 'error';
        }
    }else if(isset($_POST['auth'])){
        if(empty( $_SESSION[ 'auth' ] )){
            $_SESSION['auth'] = 'false';
        }
        echo $_SESSION['auth'];
    }else if(isset($_POST['updateprofile'])){
        $filename = $_FILES['file']['name'];
        $target_dir = "../upload/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extension_arr = array("jpg","jpeg","png","gif");
        if(in_array($imageFileType, $extension_arr)){
            if(mysqli_query($conn,"UPDATE student SET profile='$filename',fname='".$_POST['fname']."',mname='".$_POST['mname']."',lname='".$_POST['lname']."',birth='".$_POST['birth']."',gpa=".$_POST['gpa'].",affiliation='".$_POST['affiliation']."',year='".$_POST['year']."',email='".$_POST['email']."',contact='".$_POST['contact']."' WHERE id='".$_POST['studid']."';")){
                move_uploaded_file($_FILES['file']['tmp_name'], $target_dir.$filename);
            }
        }else{
            mysqli_query($conn,"UPDATE student SET fname='".$_POST['fname']."',mname='".$_POST['mname']."',lname='".$_POST['lname']."',birth='".$_POST['birth']."',gpa=".$_POST['gpa'].",affiliation='".$_POST['affiliation']."',year='".$_POST['year']."',email='".$_POST['email']."',contact='".$_POST['contact']."' WHERE id='".$_POST['studid']."';");
        }
        $getstud = $conn->query("SELECT * FROM course INNER JOIN student ON course.id = student.course_id WHERE student.id = '".$_POST['studid']."' AND birth = '".$_POST['birth']."'");
        while($row = $getstud->fetch_assoc()){
            $_SESSION['status'] = $row['status'];
            $_SESSION['auth'] = 'true||'.$row['id'].'||'.$row['profile'].'||'.$row['fname'].'||'.$row['mname'].'||'.$row['lname'].'||'.
            $row['birth'].'||'.$row['gpa'].'||'.$row['affiliation'].'||'.$row['year'].'||'.$row['status'].'||'.$row['course_name'].'||'.$row['email'].'||'.$row['contact'];
        }
        header("location:../index.html");
    }else if(isset($_POST['logout'])){
        $_SESSION['auth'] = '';
        $_SESSION['admin'] = false;
        echo 'false';
    }else if(isset($_POST['loadposition'])){
        $getPosition = $conn->query("SELECT * FROM position");
        $sid = $_POST['loadposition'];
        $type = $_POST['electype'];
        while($row = $getPosition->fetch_assoc()){
            $position = $row['id'];
            $getVote = $conn->query("SELECT * FROM vote INNER JOIN candidate INNER JOIN student ON student.id = candidate.student_id AND vote.candidate_id = candidate.student_id WHERE vote.student_id = '$sid' AND position_id = $position AND type = $type");
            echo '<button class="btn btn-modif-w-r position col-md-12" id='.$row['id'].'>'.$row['position_name'];
            while($voted = $getVote->fetch_assoc()){
                echo '<div class="col-12 text-center mb-2" style="border-top: 1px solid gray">'.$voted['fname'].' '.ucfirst(substr($voted['mname'],0,1)).'. '.$voted['lname'].'</div>';
            }
            echo '</button>';
        }
    }else if(isset($_POST['loadposforselect'])){
        $candidate = $conn->query("SELECT * FROM candidate INNER JOIN position ON candidate.position_id = position.id WHERE student_id = '".$_POST['loadposforselect']."'");
        if($candidate->num_rows){
            while($row = $candidate->fetch_assoc()){
                echo '0||'.$row['position_name'];
            }
        }else{
            echo '1||';
            $getPosition = $conn->query("SELECT * FROM position");
            while($row = $getPosition->fetch_assoc()){
                echo '<option value="'.$row['id'].'">'.$row['position_name'].'</option>';
            }
        }
    }else if(isset($_FILES['filegrade'])){
        $filename = $_FILES['filegrade']['name'];
        $filecor = $_FILES['filecor']['name'];
        $target_dir = "../gradefile/";
        $target_file = $target_dir . basename($_FILES["filegrade"]["name"]);
        $target_file_cor = $target_dir . basename($_FILES["filecor"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extension_arr = array("jpg","jpeg","png","gif");
        if(in_array($imageFileType, $extension_arr)){
            if(mysqli_query($conn,"INSERT INTO candidate(position_id,student_id,grades,approved,type,cor) VALUES(".$_POST['position'].",'".$_POST['studid']."','$filename',0,'".$_POST['candidate_type']."','$filecor')")){
                move_uploaded_file($_FILES['filegrade']['tmp_name'], $target_dir.$filename);
                move_uploaded_file($_FILES['filecor']['tmp_name'], $target_dir.$filecor);
            }
            echo 'success';
        }else{
            echo 'error';
        }
    }else if(isset($_POST['nominate'])){
        if($_SESSION['status'] == '' || $_SESSION['status'] == 1){
            if(mysqli_query($conn,"INSERT INTO vote(student_id,candidate_id) VALUES('".$_POST['studid']."','".$_POST['nominate']."')")){
                echo 'vote';
            }
        }else{
            if(mysqli_query($conn,"UPDATE candidate SET approved=1 WHERE student_id='".$_POST['nominate']."'")){
                echo 'true';
            }
        }
        
    }else if(isset($_POST['usertype'])){
        $_SESSION['usertype'] = $_POST['usertype'];
    }else if(isset($_POST['getType'])){
        echo $_SESSION['usertype'];
    }else if(isset($_POST['candidate'])){
        if($_SESSION['status'] == '' || $_SESSION['status'] == 1){$status = 1; echo '1||';}else{$status=0; echo '0||';}
        $position = $_POST['candidate'];
        $studid = $_POST['studid'];
        $candidate_type = $_POST['candidate_type'];
        $iid = $_POST['iid'];
        if($_POST['type'] == 'tally' && $candidate_type == 0){
            $getVoted = $conn->query("SELECT *,count(*) AS number,s.id AS sid FROM vote AS v INNER JOIN candidate AS c INNER JOIN student AS s INNER JOIN course AS co 
            ON c.student_id = s.id AND co.id = s.course_id AND v.candidate_id = c.student_id WHERE position_id = $position AND c.approved = 1 AND type = 0 GROUP BY s.id");
        }else if($_POST['type'] == 'tally' && $candidate_type == 1){
            $getVoted = $conn->query("SELECT *,count(*) AS number,s.id AS sid FROM vote AS v INNER JOIN candidate AS c INNER JOIN student AS s INNER JOIN course AS co 
            INNER JOIN institute AS i ON c.student_id = s.id AND co.id = s.course_id AND v.candidate_id = c.student_id AND co.institute_id = i.id
            WHERE position_id = $position AND c.approved = 1 AND type = 1 AND i.id = $iid GROUP BY s.id");
        }else{
            if($_POST['type'] == 'application'){
                $_SESSION['status'] = 'application';
            }else{$_SESSION['status'] = '';}
            if($candidate_type == 0){
                $getVoted = $conn->query("SELECT *,s.id AS sid FROM course AS co INNER JOIN student AS s INNER JOIN vote AS v INNER JOIN candidate AS c INNER JOIN position AS p 
                ON co.id = s.course_id AND s.id = v.candidate_id AND v.candidate_id = c.student_id AND p.id = c.position_id WHERE v.student_id = '$studid' AND position_id = $position AND c.approved = $status AND type = 0");
            }else{
                $getVoted = $conn->query("SELECT *,s.id AS sid FROM institute AS i INNER JOIN course AS co INNER JOIN student AS s INNER JOIN vote AS v INNER JOIN candidate AS c INNER JOIN position AS p 
                ON co.id = s.course_id AND s.id = v.candidate_id AND v.candidate_id = c.student_id AND p.id = c.position_id AND i.id = co.institute_id WHERE v.student_id = '$studid' AND position_id = $position AND c.approved = $status AND type = 1 AND i.id = $iid");
            }
        }
        if($getVoted->num_rows > 0){
            $votenum = true;
        }else{
            $votenum = false;
            if($candidate_type == 0){
                $getVoted = $conn->query("SELECT *,s.id AS sid FROM course AS co INNER JOIN student AS s INNER JOIN candidate AS c INNER JOIN position AS p ON co.id = s.course_id AND s.id = c.student_id AND c.position_id = p.id WHERE p.id = $position AND c.approved = $status AND type = 0");
            }else{
                $getVoted = $conn->query("SELECT *,s.id AS sid FROM institute AS i INNER JOIN course AS co INNER JOIN student AS s INNER JOIN candidate AS c INNER JOIN position AS p 
                ON co.id = s.course_id AND s.id = c.student_id AND c.position_id = p.id AND i.id = co.institute_id WHERE p.id = $position AND c.approved = $status  AND type = 1 AND i.id = $iid");
            }
        }

        if($_POST['type'] == 'tally'){
            echo '<div class="card" style="height: 100%; margin:0">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Tally
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Graph</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content p-0">
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 100%;overflow-y: auto;">';
        }  
        while($row = $getVoted->fetch_assoc()){
            if($row['profile'] == ''){ $profile = 'dist/img/profile.png';}
            else{ $profile = 'upload/'.$row['profile'];}
            echo '<div class="col-md-12 row box">
                <img src="'.$profile.'" class="col-md-3">
                <div class="col-md-7">
                    <div class="row">';
                        if($_POST['type'] == 'tally' || $_POST['type'] == 'application'){
                        echo '<div class="col-sm-6 row">
                            <label class="col-md-10">ID</label>
                            <div class="col-md-12">
                                <input required class="form-control form-control-sm" disabled value="'.$row['sid'].'" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6 row">
                            <label class="col-md-10">Name</label>
                            <div class="col-md-12">
                                <input required class="form-control form-control-sm studname" disabled value="'.ucfirst($row['fname']).' '.ucfirst(substr($row['mname'],0,1)).'. '.ucfirst($row['lname']).'" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6 row">
                            <label class="col-md-10">Birth</label>
                            <div class="col-md-12">
                                <input required class="form-control form-control-sm" disabled value="'.date('m-d-Y',strtotime($row['birth'])).'" type="text">
                            </div>
                        </div>
                        <div class="col-sm-6 row">
                            <label class="col-md-10">Year</label>
                            <div class="col-md-12">
                                <input required class="form-control form-control-sm" disabled value="'.$row['year'].'" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12 row">
                            <label class="col-md-10">Course</label>
                            <div class="col-md-12">
                                <input required class="form-control form-control-sm" disabled value="'.$row['course_name'].'" type="text">
                            </div>
                        </div>
                        <div class="col-sm-12 row">
                            <label class="col-md-10">Affiliation</label>
                            <div class="col-md-12">
                                <textarea class="form-control form-control-sm affil" rows="2" disabled id="affiliation" name="affiliation">'.$row['affiliation'].'</textarea>
                            </div>
                        </div>';}else{
                        echo '<div class="col-sm-12 row">
                            <label class="col-md-2">Name</label>
                            <div class="col-md-10">
                                <input required class="form-control form-control-sm studname" disabled value="'.ucfirst($row['fname']).' '.ucfirst(substr($row['mname'],0,1)).'. '.ucfirst($row['lname']).'" type="text">
                            </div>
                        </div>';}
                    echo '</div>
                </div>
                <div class="col-md-2 side-btn">';
                    if($_POST['type'] == 'tally'){ 
                        echo '<label class="col-md-10 count-label" id="'.$row['sid'].'">Count of Vote: '.$row['number'].'</label> <input type="hidden" value="'.$row['number'].'" class="votecount">';
                    }else if($_SESSION['status'] == '' || $_SESSION['status'] == 1){
                        if($votenum){
                            echo '<button class="btn btn-primary col-12" disabled>VOTED</button>';
                        }else{
                            echo '<button class="btn btn-success col-12" id="'.$row['sid'].'">VOTE</button>';
                        }
                    }else{
                        echo '<div class="cont-btn"><button class="btn btn-success btn-approve col-12" id="'.$row['sid'].'">APPROVE</button>
                        <button class="btn btn-danger btn-disapprove col-12 mt-2" value="'.$row['sid'].'">DISAPPROVE</button>
                        <button class="btn btn-outline-secondary btn-grade mt-2 col-12" data-target="#viewgrade" value="'.$row['sid'].'" data-toggle="modal">grade</button></div>
                        <button class="btn btn-outline-secondary btn-cor mt-2 col-12" data-target="#viewcor" value="'.$row['sid'].'" data-toggle="modal">C.O.R</button></div>';
                    }
                echo '</div>
            </div>';
        }
        if($_POST['type'] == 'tally'){               
            echo '</div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 100%;">
                    <div id="chart" style="min-height: 300px; height: 500px; max-width: 100%;"></div>         
                </div>  
            </div>
            </div>
        </div>';
        }
        $_SESSION['status'] == '';
    }else if(isset($_POST['subjectpaging'])){
        $institute = $_POST['institute'];
        $search = $_POST['searching'];
        $start = $_POST['subjectpaging'];
        $ap = $start;
        $getCount = $conn->query("SELECT * FROM institute AS i INNER JOIN course AS c INNER JOIN student AS s 
        ON i.id = c.institute_id AND c.id = s.course_id  WHERE i.id = $institute AND (s.id LIKE '%$search%' OR fname LIKE '%$search%' 
        OR mname LIKE '%$search%' OR lname LIKE '%$search%')");
        $count = $getCount->num_rows/10;
        $count = ceil($count);
        $start = max($start - 4, 0);
        if($start == 0){$start = 1;}
        if($count < 8){$pagecount = $count;$start = 1;}
        else if($start > ($count - 7)){$pagecount = $count; $start = $count - 6;}
        else{$pagecount = $start + 7;}
        echo '<li class="page-item"><a class="page-link 0" href="#">«</a></li>';
        $j = 0;
        for($i = $start; $i <= $pagecount ;$i++){
            if($ap == $j){$active = "page-item active";$ap++;}
            else if($ap == $i){$active = "page-item active";}
            else if($ap == $i+1 && $ap == $count+1){$active = "page-item active";}
            else{$active = "page-item";}
            echo '<li class="'.$active.'"><a class="page-link '.$i.'" href="#">'.$i.'</a></li>';
        }
        echo '<li class="page-item"><a class="page-link '.$count.'" href="#">»</a></li>';
    }else if(isset($_POST['getStudent'])){
        $search = $_POST['getStudent'];
        $page = $_POST['page'];
        $page = max($page-1,0);
        $page = $page*10;
        $institute = $_POST['institute'];
        $getStud = $conn->query("SELECT * FROM institute AS i INNER JOIN course AS c INNER JOIN student AS s ON i.id = c.institute_id AND c.id = s.course_id 
        WHERE i.id = $institute AND (s.id LIKE '%$search%' OR fname LIKE '%$search%' OR mname LIKE '%$search%' OR lname LIKE '%$search%') LIMIT $page,10");
        while($row = $getStud->fetch_assoc()){
            echo '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['lname'].', '.$row['fname'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['contact'].'</td>
                <td><button class="btn btn-'; if($row['status'] == '' || $row['status'] == 1){echo 'primary';}else{ echo 'success';}echo ' select" id="'.$row['id'].'"><i class="fa fa-check" aria-hidden="true"></i></button></td>
            </tr>';
        }
    }else if(isset($_POST['getComelec'])){
        $institute = $_POST['getComelec'];
        $getCom = $conn->query("SELECT * FROM institute AS i INNER JOIN course AS c INNER JOIN student AS s ON i.id = c.institute_id AND c.id = s.course_id WHERE i.id = $institute AND status = 0");
        while($row = $getCom->fetch_assoc()){
            echo '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['lname'].', '.$row['fname'].'</td>
                <td><button class="btn btn-danger stud-delete" id="'.$row['id'].'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
            </tr>';
        }
    }else if(isset($_POST['createcom'])){
        if(mysqli_query($conn,"UPDATE student SET status = 0 WHERE id = '".$_POST['createcom']."'")){echo 'true';}
        else{echo 'false';}
    }else if(isset($_POST['dropcom'])){
        if(mysqli_query($conn,"UPDATE student SET status = 1 WHERE id = '".$_POST['dropcom']."'")){echo 'true';}
        else{echo 'false';}
    }else if(isset($_POST['loadadmin'])){
        $getAdmin = $conn->query("SELECT * FROM admin");
        while($row = $getAdmin->fetch_assoc()){
            echo '<tr>
                <td>'.$row['fname'].'</td>
                <td>'.$row['mname'].'</td>
                <td>'.$row['lname'].'</td>
                <td>'.$row['username'].'</td>
                <td><button class="btn btn-danger admin-delete" id="'.$row['id'].'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
            </tr>';
        }
    }else if(isset($_POST['deleteadmin'])){
        if(mysqli_query($conn,"DELETE FROM admin WHERE id = ".$_POST['deleteadmin'])){
            echo 'true';
        }
    }else if(isset($_POST['insertadmin'])){
        $fname = $_POST['insertadmin'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $user = $_POST['username'];     
        $pass = $_POST['pass'];
        if(mysqli_query($conn,"INSERT INTO admin(fname,mname,lname,username,password) VALUES('$fname','$mname','$lname','$user','$pass')")){
            echo 'success';
        }
    }else if(isset($_POST['loadIns'])){
        $loadins = $conn->query("SELECT * FROM institute");
        while($row = $loadins->fetch_assoc()){
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }else if(isset($_POST['loadImg'])){
        $getImg = $conn->query("SELECT * FROM candidate WHERE student_id = '".$_POST['loadImg']."'");
        while($row = $getImg->fetch_assoc()){
            echo 'gradefile/'.$row['grades'];
        }
    }else if(isset($_POST['loadCORImg'])){
        $getImg = $conn->query("SELECT * FROM candidate WHERE student_id = '".$_POST['loadCORImg']."'");
        while($row = $getImg->fetch_assoc()){
            echo 'gradefile/'.$row['cor'];
        }
    }else if(isset($_POST['comment'])){
        if(mysqli_query($conn,"UPDATE candidate SET approved = 2, comment = '".$_POST['comment']."' WHERE student_id = '".$_POST['sid']."'")){
            echo "The candidate's application will be disallowed.";
        }
    }else if(isset($_POST['electtable'])){
        $getElect = $conn->query("SELECT * FROM open_elect");
        while($row = $getElect->fetch_assoc()){
            echo '<tr>
                <td>'.$row['application_open'].'</td>
                <td>'.$row['application_close'].'</td>
                <td>'.$row['vote_start'].'</td>
                <td>'.$row['vote_end'].'</td>
                <td>'.$row['sy'].'</td>
            </tr>';
        }
    }else if(isset($_POST['application_open'])){
        $app_open = $_POST['application_open'];
        $app_close = $_POST['application_close'];
        $vote_start = $_POST['start_vote'];
        $vote_end = $_POST['end_vote'];
        $sy = $_POST['sy'];
        if(mysqli_query($conn,"INSERT INTO open_elect(application_open,application_close,vote_start,vote_end,sy) VALUES('$app_open','$app_close','$vote_start','$vote_end','$sy')")){
            echo true;
        }else{
            echo false;
        }
    }else if(isset($_POST['isVote'])){
        echo "Example";
        // $isVote = $conn->query("SELECT * FROM open_elect where vote_start < now() and vote_end > now()");
        // if($isVote->num_rows != 0){
        //     echo true;
        // }else{ echo false;}
    }else if(isset($_POST['isApply'])){
        echo "This is my sample";
        // $isApply = $conn->query("SELECT * FROM open_elect where application_open < now() and application_close > now()");
        // if($isApply->num_rows != 0){
        //     echo true;
        // }else{
        //     echo false;
        // }
    }
?>