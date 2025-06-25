<?php

$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendanceapp/database/database.php";
function clearTable($dbo,$tabName)
{
    $c="delete from :tabname";
    $s=$dbo->conn->prepare($c);
    try{
    $s->execute([":tabname"=>$tabName]);
    }
    catch(PDOException $oo)
    {

    }
}
$dbo=new Database();
$c="create table student_details
(
    id int auto_increment primary key,
    roll_no varchar(20) unique,
    name varchar(50)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>student_details created");
}
catch(PDOException $o)
{
echo("<br>student_details not created");
}

$c="create table course_details
(
    id int auto_increment primary key,
    code varchar(20) unique,
    title varchar(50),
    credit int
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>course_details created");
}
catch(PDOException $o)
{
echo("<br>course_details not created");
}


$c="create table faculty_details
(
    id int auto_increment primary key,
    user_name varchar(20) unique,
    name varchar(100),
    password varchar(50)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>faculty_details created");
}
catch(PDOException $o)
{
echo("<br>faculty_details not created");
}


$c="create table session_details
(
    id int auto_increment primary key,
    year int,
    term varchar(50),
    unique (year,term)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>session_details created");
}
catch(PDOException $o)
{
echo("<br>session_details not created");
}



$c="create table course_registration
(
    student_id int,
    course_id int,
    session_id int,
    primary key (student_id,course_id,session_id)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>course_registration created");
}
catch(PDOException $o)
{
echo("<br>course_registration not created");
}

$c="create table course_allotment
(
    faculty_id int,
    course_id int,
    session_id int,
    primary key (faculty_id,course_id,session_id)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>course_allotment created");
}
catch(PDOException $o)
{
echo("<br>course_allotment not created");
}

$c="create table attendance_details
(
    faculty_id int,
    course_id int,
    session_id int,
    student_id int,
    on_date date,
    status varchar(10),
    primary key (faculty_id,course_id,session_id,student_id,on_date)
)";
$s=$dbo->conn->prepare($c);
try{
$s->execute();
echo("<br>attendance_details created");
}
catch(PDOException $o)
{
echo("<br>attendance_details not created");
}

$c="insert into student_details
(id,roll_no,name)
values
  (1,'1AM21IS001','BHASKAR'),
  (2,'1AM21IS034','PALLABI BORA'),
  (3,'1AM21IS003','PRERONA SAIKIA'),
  (4,'1AM21IS023','SWAPNIL DEB'),
  (5,'1AM21IS035','AONEK AMARTYA '),
  (6,'1AM21IS036','ANTARIP LAHKAR'),
  (7,'1AM21IS037','GURVINDRA SINGH'),
  (8,'1AM21IS038','DEBANGANA SAHA'),
  (9,'1AM21IS039','PRANAY BHARAT GAIKWAD'),
  (10,'1AM21IS093','ROMIT KUMAR'),
  (11,'1AM21IS040','TAMANNA NEGER'),
  (12,'1AM21IS113','VINOD KUMAR N'),

  (13,'1AM21CS001','UTTARA SAHA'),
  (14,'1AM21CS002','PROBAL DEEP SAIKIA'),
  (15,'1AM21CS003','SUBHROJIT SAIKIA'),
  (16,'1AM21AI004','GURLEEN KAUR'),
  (17,'1AM21AI030','RACHNA HARLALKA'),
  (18,'1AM21AI031','CHITRANKANA BHOWMIK'),
  (19,'1AM21AI032','HRITTIK BARUAH'),
  (20,'1AM21AI033','PRAGYANUR SAIKIA'),
  (21,'1AM21AI034','BIKRAM UPADHYAYA'),
  (22,'1AM21AI035','SHABBIR AHMAD'),
  (23,'1AM21AI036','ARNAB BISWAS'),
  (24,'1AM21AI037','NAROTTAM GOGOI')";

  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into faculty_details
(id,user_name,password,name)
values
(1,'ise1','123','Ram Charan Baishya'),
(2,'ise2','123','Arindam Karmakar'),
(3,'ise3','123','Pallabi'),
(4,'cse','123','Anuj Agarwal'),
(5,'ai1','123','Mriganka Sekhar'),
(6,'ai2','123','Manooj Hazarika')";

  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into session_details
(id,year,term)
values
(1,2023,'ODD SEMESTER'),
(2,2023,'EVEN SEMESTER')";

  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }


  $c="insert into course_details
(id,title,code,credit)
values
  (1,'Database management system lab','CO321',2),
  (2,'Pattern Recognition','CO215',3),
  (3,'Data Mining & Data Warehousing','CS112',4),
  (4,'ARTIFICIAL INTELLIGENCE','CS670',4),
  (5,'THEORY OF COMPUTATION ','CO432',3),
  (6,'DEMYSTIFYING NETWORKING ','CS673',1)";
  $s=$dbo->conn->prepare($c);
  try{
    $s->execute();
  }
  catch(PDOException $o)
  {
    echo("<br>duplicate entry");
  }

  //if any record already there in the table delete them
  clearTable($dbo,"course_registration");
  $c="insert into course_registration
  (student_id,course_id,session_id)
  values
  (:sid,:cid,:sessid)";
  $s=$dbo->conn->prepare($c);
  //iterate over all the 24 students
  //for each of them chose max 3 random courses, from 1 to 6

  for($i=1;$i<=24;$i++)
  {
    for($j=0;$j<3;$j++)
    {
        $cid=rand(1,6);
        //insert the selected course into course_registration table for 
        //session 1 and student_id $i
        try{
           $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>1]); 
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2
        $cid=rand(1,6);
        //insert the selected course into course_registration table for 
        //session 2 and student_id $i
        try{
           $s->execute([":sid"=>$i,":cid"=>$cid,":sessid"=>2]); 
        }
        catch(PDOException $pe)
        {

        }
    }
  }


  //if any record already there in the table delete them
  clearTable($dbo,"course_allotment");
  $c="insert into course_allotment
  (faculty_id,course_id,session_id)
  values
  (:fid,:cid,:sessid)";
  $s=$dbo->conn->prepare($c);
  //iterate over all the 6 teachers
  //for each of them chose max 2 random courses, from 1 to 6

  for($i=1;$i<=6;$i++)
  {
    for($j=0;$j<2;$j++)
    {
        $cid=rand(1,6);
        //insert the selected course into course_allotment table for 
        //session 1 and fac_id $i
        try{
           $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>1]); 
        }
        catch(PDOException $pe)
        {

        }

        //repeat for session 2
        $cid=rand(1,6);
        //insert the selected course into course_allotment table for 
        //session 2 and student_id $i
        try{
           $s->execute([":fid"=>$i,":cid"=>$cid,":sessid"=>2]); 
        }
        catch(PDOException $pe)
        {

        }
    }
  }