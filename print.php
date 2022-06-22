<?php
    include("db/DBConnection.php");
    global $conn;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .page-header, .page-header-space {
          height: 190px;
          text-align: center;
          margin-top:7mm
        }
        .page-footer-space {
          height: 100px;
        }
        .footer{
            background-color:blue;
            position:fixed;
            bottom: 0;
            margin:0px;
            text-align:center;
            height:80px;
            width: 100%;
          }
        table{
          width:94%;
          margin:auto;
        }
        .tcont{
            border-bottom: 2px solid blue;
            border-top: 2px solid blue;
            margin-top: 7px;
        }
        .tcont h1{
            color:blue;
            margin-top: 5px;
        }
        #logo{
            height: 130px;
            width: 130px;
            margin-bottom: 0px;
        }
        .tcont p{
            margin-top: -14px;
        }
        .page-header {
            position: fixed;
            top: 0mm;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
        }
        .container{
            page-break-inside: avoid;
        }
        #title{
            margin-top: -7px;
        }
        @page {
            size: A4;
            margin: 0mm;
        }
        @media print {
            thead {display: table-header-group;} 
           body {margin: 0;}
        }

        .title-div{
            display: inline-block;
            text-align: left;
        }
        .right{
            float: right;
        }

        .left{
            float: left;
        }

        .logo{
            position: absolute;
            flex: auto;
            height: 150px;
            right: 0;
            top: 0;
        }

        .position>h2{
            letter-spacing: 3px;
            border-bottom: 1px solid gray;
        }

        .container{
            width: 100%;
            border: 1px solid gray;
            text-align: center;
            margin-bottom: 17px;
        }

        .candidate{
            display: inline-block;
            margin: 10px 40px;
            text-align: left;
        }

        .candidate>p{
            font-family: arial;
            letter-spacing: 1px;
            font-size: 18px;
            margin: 3px 0;
        }

        .candidate>a{
            font-size: 17px;
            font-weight: 550;
            text-align: justify;
            text-justify: inter-word;
        }
    </style>
</head>
<body>
    <div class='page-header'>
        <div class="left title-div">
            <b>Republic of the philippines</b>
            <div class='tcont'>
            <h1>DAVAO ORIENTAL <br>STATE UNIVERSITY</h1>
            <p>"A university of excellence, innovation, and inclusion"</p>
        </div>
        <img src="dist/img/credit/dorsu.png" class="logo">
    </div>
    </div>
    <table>
        <thead>
            <tr>
            <td>
                <div class='page-header-space'></div>
            </td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>
                <div class='page'>
                        <?php
                            $getPosition = $conn->query("SELECT * FROM position");
                            while($position = $getPosition->fetch_assoc()){
                        ?>
                        <div class="container">
                            <div class="position">
                                <h2><?php echo $position['position_name']?></h2>
                            </div>
                            <?php 
                            $places = ['1st','2nd','3rd','4th','5th','6th','7th'];
                            $i = 0;
                            $pid = $position['id'];
                            $getCandidate = $conn->query("SELECT count(*) AS count,fname,mname,lname FROM vote AS v INNER JOIN candidate AS c INNER JOIN student AS s ON v.candidate_id = c.student_id AND c.student_id = s.id WHERE c.position_id = $pid GROUP BY v.candidate_id ORDER BY count DESC");
                                while($candidate = $getCandidate->fetch_assoc()){
                            ?>
                                <div class="candidate">
                                    <i><?php echo $places[$i]?></i>
                                    <p><?php echo $candidate['lname'].' '.$candidate['fname'].' '.strtoupper(substr($candidate['mname'], 0, 1)).'.'?></p>
                                    <a>Vote: <?php echo $candidate['count']?></a>
                                </div>
                            <?php
                                $i++;
                                }
                            ?>
                        </div>
                        <?php
                            }
                        ?>
                </div>
            </div>
            </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
            <td>
                <div class='page-footer-space'></div>
            </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.print();
    </script>
</body>
</html>