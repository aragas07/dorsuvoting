<?php
    include('DBConnection.php');
    global $conn;
    $filename=$_FILES["file"]["tmp_name"];		
        if($_FILES["file"]["size"] > 0){
            $file = fopen($filename, "r");
            $x = 0;
            while (($getData = fgetcsv($file, 100000, ",")) !== FALSE){
                $x++;
                if($x == 1){
                    if(strcmp(strtolower($getData[0]),"id") != 0 || strcmp(strtolower($getData[1]),"first name") != 0 || strcmp(strtolower($getData[2]),"middle name") != 0 || strcmp(strtolower($getData[3]),"last name") != 0 || strcmp(strtolower($getData[4]),"birth") != 0 || strcmp(strtolower($getData[5]),"email") != 0 || strcmp(strtolower($getData[6]),"contact") != 0 || strcmp(strtolower($getData[7]),"course") != 0 || strcmp(strtolower($getData[8]),"year") != 0 || strcmp(strtolower($getData[9]),"gpa") != 0){
                        $_SESSION['errorfile'] = true;
                        header("location:../superadmin/#");
                    }
				}else{
                    $course = $getData[7];
                    $getcourse = $conn->query("SELECT * FROM course WHERE course_name LIKE '%$course%' OR acronyms LIKE '%$course%'");
                    $courseid = 0;
                    while($getc = $getcourse->fetch_assoc()){
                        $courseid = $getc['id'];
                    }
                    $date = date('Y-m-d',strtotime($getData[4]));
                    mysqli_query($conn,"INSERT INTO student(id,fname,mname,lname,birth,email,contact,course_id,status,year,gpa) VALUES('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','$date','".$getData[5]."','".$getData[6]."','$courseid','1','".$getData[8]."','".$getData[9]."')");
                    
                }
            }
            fclose($file);	
            $_SESSION['fileuploaded'] = true;
            header("location:../superadmin/#");
        }

        ?>