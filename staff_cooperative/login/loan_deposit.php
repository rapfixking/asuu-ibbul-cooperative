<?php
	ob_start();
	session_start();
	require_once 'dbconnect.php';
	
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['admin']) ) {
		header("Location: index.php");
		exit;
	}
	$conn = mysqli_connect('localhost','root','','cooperative');

	// select loggedin users detail
	$conn = mysqli_connect('localhost','root','','cooperative');
	$res=mysqli_query($conn,"SELECT * FROM users WHERE userId=".$_SESSION['admin']);
	$userRow=mysqli_fetch_array($res);

	$ress=mysqli_query($conn,"SELECT * FROM personalinfo_tbl WHERE cust_id='$userRow[userName]'");
	$userRows=mysqli_fetch_array($ress);
	$cust_fname = $userRows['cust_fname'];
	$cust_oname = $userRows['cust_oname'];
	$cust_lname = $userRows['cust_lname'];
	$cust_staffstatus = $userRows['cust_staffstatus'];
	$cust_healthstatus = $userRows['cust_healthstatus'];
	$cust_staffid = $userRows['cust_staffid'];
	$cust_nok = $userRows['cust_nok'];


	@$passave=@mysqli_query($conn,"SELECT * FROM savingamount_tbl WHERE cust_id='$cust_id' and savings_status='1' ORDER BY SN DESC");
	@$userPassave=@mysqli_fetch_array($passave);
	$cust_savings = $userPassave['cust_savings'];


	$cust_nokrelationship = $userRows['cust_nokrelationship'];
	$cust_noknum = $userRows['cust_noknum'];
	$cust_school = $userRows['cust_school'];
	$cust_department = $userRows['cust_department'];

	@$pass=@mysqli_query($conn,"SELECT * FROM passport_tbl WHERE AppNumber='$userRow[userName]'");
	@$userPass=@mysqli_fetch_array($pass);

	$pass=mysqli_query($conn,"SELECT * FROM personalinfo_tbl WHERE cust_id='$userRow[userName]'");
	$userPass=mysqli_fetch_array($pass);
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userName']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
<style>
	.wrapper{
		padding-top: 50px;
	}
	#form-content{
		margin: 0 auto;
		width: 600px;
	}
	.FixedHeightContainer
{
  float:right;
  height: 350px;
  padding:10px; 
    background:#f00;
}
.Content
{
  height:350px;
   overflow:auto;
    background:#fff;
}
</style></head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Admin Dashboard</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">     <?php 	$report1=mysqli_query($conn,"SELECT * FROM loanrequest_tbl WHERE report='0'");

	$report2=mysqli_query($conn,"SELECT * FROM savingamount_tbl WHERE report='0'");


	$msg1=mysqli_query($conn,"SELECT * FROM loanrequest_tbl WHERE msg='0'");

	$msg2=mysqli_query($conn,"SELECT * FROM savingamount_tbl WHERE msg='0'");

if ((mysqli_num_rows($report1) > 0) or (mysqli_num_rows($report2) > 0)){$rep="rep1.jpg";} else {$rep="rep.jpg";}

if ((mysqli_num_rows($msg1) > 0) or (mysqli_num_rows($msg2) > 0)){$msg="msg1.jpg";} else {$msg="msg.jpg";}
?>     <ul class="nav navbar-nav">            <li><a href="admin_detail.php">Home</a></li>
            <li><a href="members_detail.php">Members</a></li>			<li><a href="membersloan_detail.php">Loan</a></li>
            <li><a href="memberssavings_detail.php">Savings</a></li>
<li><a href="savings_deposit.php">S.Deposit</a></li>
<li><a href="loan_deposit.php">L.Deposit</a></li>
            <li><a href="expenditure.php">Expenditure</a></li>
<li><a href="admin_report.php" title="See Messages"><img name="" src="<?php echo $msg; ?>" width="20" height="20" alt=""></a></li>
            <li><a href="#" title="Generate Report"><img name="" src="<?php echo $rep; ?>" width="20" height="20" alt=""></a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">			  <span class="glyphicon glyphicon-user"></span>&nbsp;Admin ID:<strong><?php echo $userRow['userName']; ?> </strong>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">                <li><a href="dividend.php"></span>&nbsp;Share Dividend</a></li>                <li><a href="dividend_edit.php"></span>&nbsp;Delete Dividend</a></li>
                <li><a href="print_mandate.php"></span>&nbsp;Print Mandate</a></li>
                <li><a href="savings_deduction.php"></span>&nbsp;Print Deduction</a></li>
                <li><a href="select_report.php"></span>&nbsp;Retrieve Mandate</a></li>
                <li><a href="select_reportb.php"></span>&nbsp;Retrieve Deduction</a></li>

<li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
</ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav> 

	<div id="wrapper">
<div style="background-image: url(../onlineapp/ccslogo/header.jpg); background-repeat: no-repeat center center; background-size: cover; height: 150px"></div>
	<div class="container"><br>
	  <div id="form-content"><br><div class="FixedHeightContainer Content"><br><table width="100%" border="0" class="table table-striped">
  <tr>
    <td colspan="6">LOAN DEPOSIT RECORD/TRANSACTIONS <span style="color:#F00"><strong>ACTIVE</strong></span></td>
    </tr>
  <tr>
    <td><strong>Customer Name</strong></td>
    <td><strong>Loan Amount</strong></td>
    <td><strong>Duration</strong></td>
    <td><strong>Monthly Pay</strong></td>
    <td><strong>No. Left</strong></td>
    <td><strong>Status</strong></td>
  </tr>





<?php 
$conn = mysqli_connect('localhost','root','','cooperative');
$detaila = mysqli_query($conn,"SELECT * FROM loanrequest_tbl WHERE loan_status='1'");
while ($detailfetcha=mysqli_fetch_array($detaila)){?>  
<?php

$cust_id=$detailfetcha['cust_id'];
$loan_id=$detailfetcha['loan_id'];
$loan_amount=$detailfetcha['loan_amount'];
$loan_duration=$detailfetcha['loan_duration'];
$loan_status=$detailfetcha['loan_status'];
$loan_complete=$detailfetcha['loan_complete'];
$loan_date=$detailfetcha['loan_date'];

$loanpay=mysqli_query($conn,"SELECT * FROM loan_tbl WHERE loan_id='$loan_id' ORDER by loan_count ASC LIMIT 1");
$newtime=mysqli_fetch_array($loanpay); 
$loan_countnext=$newtime['loan_countnext'];
$loan_count=$newtime['loan_count'];
if (($loan_countnext == 0) and ($loan_complete <> 1)) {$loan_countnext = $loan_duration;}
$custsave=mysqli_query($conn,"SELECT * FROM personalinfo_tbl WHERE cust_id='$cust_id'");
$custsavev=mysqli_fetch_array($custsave);
$cust_fname=$custsavev['cust_fname'];
$cust_oname=$custsavev['cust_oname'];
$cust_lname=$custsavev['cust_lname'];

$monthly=mysqli_query($conn,"SELECT * FROM loanpayment_tbl WHERE loan_id='$loan_id'");
$monthlyrow=mysqli_fetch_array($monthly);
$monthlypay=$monthlyrow['principal'] + $monthlyrow['interest'];

?>
<tr>    

<td><a href="customerdetail_admin.php?page=null&cust_id=<?php echo $cust_id; ?>" title="<?php echo $cust_id; ?>"><?php echo $cust_lname; ?> <?php echo $cust_fname; ?> <?php echo $cust_oname; ?></a></td>
    <td><?php echo $loan_amount; ?></td>
    <td><?php echo $loan_duration; ?></td>
    <td><?php echo $monthlypay; ?></td>
    <td><?php echo $loan_countnext; ?></td>
    <td><?php if (($loan_countnext == 0) and ($loan_count > 0)){echo "<span style='color:#F00'><strong>COMPLETE</strong></span>";} else{echo "<span style='color:#004400'><strong>ACTIVE</strong></span>";} ?></td>
  </tr> <?php }?>
</table></div><br><form method="post" action="submitloans.php" id="reg-form" autocomplete="off">
		<input name="cust_id" type="hidden" value="<?php echo $cust_id; ?>">		
		<input name="loan_amount" type="hidden" value="<?php echo $loan_amount; ?>">		
		<input name="loan_id" type="hidden" value="<?php echo $loan_id; ?>">		
		<input name="loan_count" type="hidden" value="<?php echo $loan_count; ?>">		
		<input name="monthlypay" type="hidden" value="<?php echo $monthlypay; ?>">		
		<input name="loan_countnext" type="hidden" value="<?php echo $loan_countnext; ?>">		
		<input name="payment_status" type="hidden" value="1">		
        <div class="form-group">
<label>Please Select Month for Deposit</label>
:
<input name="date_deposit" type="month" required>  
				</div>				
                <div class="form-group">
				  <button class="btn btn-primary" name="submit"> - MAKE DEPOSITS - </button>
				</div>

				
			</form>  </div>
  </div>
    
    </div>
    
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>