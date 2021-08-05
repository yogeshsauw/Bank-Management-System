_Admin_

<?php
 session_start();
 $a=$_POST["user1"];
 $b=$_POST["pass1"];
 $c=$_POST["pass1"];
 $_SESSION['user1']=$user1;
 $_SESSION['pass1']=$pass1;
 $cc=mysql_connect("localhost","root","");
 mysql_select_db("hostel");
 $abc="CREATE TABLE IF NOT EXISTS 'adm_account'
 (
  'id' INT(20) NOT NULL AUTO_INCREMENT,
  'user' VARCHAR(60) NOT NULL,
  'pass' VARCHAR(60) NOT NULL,
  'pass_r' VARCHAR(60) NOT NULL,PRIMARY KEY('id')
 )";
 mysql_query($abc);
 $sql="insert into adm_account (user,pass,pass_r) values ('$user1','$pass1','$pass1')";
 mysql_query($sql);
 mysql_close($cc);
?>

_Admin login_

<?
 session_start();
 if(isset($_REQUEST['sub1']))
 {
  $user=$_REQUEST['user1'];
  $pass=$_REQUEST['pass1'];
  $cc=mysql_connect("localhost","root","");
  mysql_select_db("hostel");
  $sql="SELECT * FROM adm_account where user1='$user' AND pass1='$pass'";
  $res=@mysql_query($sql);
  $a=@mysql_affected_rows();
  if($a>=1)
  $num=mysql_num_rows($res);
  if($num>0)
  {
   $_SESSION['pass']=$pass;
   $_SESSION['user']=$user;
   header("location:admin_home.php");
  }
  else
  {
   $flag=1;
   $msg="Wrong username or password";
  }
 }
?>

_Javascript validation code_

function validate(f)
{
  if((f.user.value=="")||(f.user.value.length<5))
    {
      alert("Please enter a valid username");
      f.user.focus();return false;
    }
  if((f.pass.value=="")||(f.pass.value.length<6))
   {
     alert("Please enter a valid password");
     f.pass.focus();return false;
   }
  return true;
}

_Student Details_

<?
 phpsession_start();
 if(!(isset($_SESSION['user'])) && !(isset($_SESSION['pass'])))
 header("location:index.php");
 include_once("include_files/db.php");
 $con=new dbconnect();
 $con->open();

 if(isset($_REQUEST['edit']))
 {
  $year=$_REQUEST['year'];
  $message="For"." "."-".$year.""."Batch";
  $table=$year.'r';
  $f1=0;$f2=0;
  $table_a=$year.'a';
  $sql="SELECT * FROM $table_a";
  $result=@mysql_query($sql);
  $total_num=@mysql_num_rows($result);
  if($total_num<=0)
   {
   $f1=1;
   }
  $table_i=$year.'i';
  $sql="SELECT * FROM $table_i";
  $result=@mysql_query($sql);
  $total_num=@mysql_num_rows($result);
  if($total_num<=0)
   {
   $f2=1
   }

  $s_code=substr($sem,1,1);
  $stud_num=$_REQUEST['stud_num'];

  for($i=1;$i<=$stud_num;$i++)
   {
    $id[$i]=$_POST["id".$i];
    $roll_no[$i]=$_POST["roll_no".$i];
    $reg_no[$i]=$_POST["reg_no".$i];
    $name[$i]=$_POST['name'.$i];
    $email[$i]=$_POST['email'.$i];
   }
  for($i=1;$i<=$stud_num;$i++)
   {
    $sql="UPDATE $table SET roll_no='{$roll_no[$i]}',reg_no='{$reg_no[$i]}',name='{$name[$i]}',email='{$email[$i]}' WHERE id='{$id[$i]}'";
    $con->update($sql);
    if($f1==0)
     {
      $sql_a="UPDATE $table_a SET roll_no='{$roll_no[$i]}',name='{$name[$i]}' WHERE id='{$id[$i]}'";
      $con->update($sql_a);
     }
   if($f2==0)
    {
     $sql_i="UPDATE $table_i SET roll_no='{$roll_no[$i]}',name='{$name[$i]}' WHERE id='{$id[$i]}'";$con->update($sql_i);
    }
   }
  header("location:stud_edit.php?year={$year}");
 }
 if(isset($_REQUEST['delete']))
 {
  $year=$_REQUEST['year'];
  $table=$year.'r';
  $sql="DROP TABLE $table";
  @mysql_query($sql);
  header("location:admin_home.php");
 }
?>

_Storing values from database_

$i=1;
while($row=@mysql_fetch_array($result))
 {
  $id[$i]=$row['id'];
  $roll_no[$i]=$row['roll_no'];
  $reg_no[$i]=$row['reg_no'];
  $name[$i]=$row['name'];
  $email[$i]=$row['email'];
  $i++;
 }