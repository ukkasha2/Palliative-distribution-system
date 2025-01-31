<?php
/* session_start();
include('db.php'); */
$pdo = null;
	function prepareConnection(){
		$host ="127.0.0.1";
		$db ="palliativecare_db";
		$username ="root";
		$password ="";

		try{
			$pdo = new PDO('mysql:host='.$host.';dbname='.$db , $username , $password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(Exception $e){
			echo "Ooops! Something is wrong with the Connection\nPlease Contact the System Adminstrator";
			echo $e->getMessage();
		}
		return $pdo;
	}
	if($pdo == null){
		$pdo = prepareConnection();
	}


//$r= mysqli_query($connection,"SELECT fingerprint FROM `student_tbl` WHERE admin_number='1510207003'");
/* $r= mysqli_query($connection,"SELECT fingerprint FROM `student_tbl` WHERE admin_number='1510207003'");
$rowss=mysqli_fetch_array($r);
$fingerdata=$rowss['fingerprint']; */
$sql="SELECT fingerprint_template FROM users_fingerprints";
$stmt=$pdo->prepare($sql);
$stmt->execute();
$stds=$stmt->fetchAll(PDO::FETCH_ASSOC);
$std=$stds[0];
$fingerdata = $std['fingerprint_template'];
var_dump($fingerdata);
?>

<html>
<head>
	<title>Match Test</title>
</head>
<script language="javascript" type="text/javascript">

var flag =0;
var quality = 60; //(1 to 100) (recommanded minimum 55)
var timeout = 10; // seconds (minimum=10(recommanded), maximum=60, unlimited=0

function Match() {
try {
        //var isotemplate = document.getElementById('txtIsoTemplate').value;
       var isotemplate = <?php echo json_encode($fingerdata); ?>;
        var res = MatchFinger(quality, timeout, isotemplate);
        if (res.httpStaus){
            if (res.data.Status){
                alert("Fingerprint matched Found!");
              // $figer_print_data = $std['finger_print'];
                // window('location.href="criminal_detail.php?finger=<?php// echo $finger_print_data;?>
            }
            else{
                if (res.data.ErrorCode != "0") {
                    alert(res.data.ErrorDescription);
                }
                else {
                    alert("Fingerprint matched Not Found!");
                }
            }
        }
        else {
            alert(res.err);
        }
    }
    catch (e) {
        alert(e);
    }
    return false;

}




</script>
<body>
	<form>
		
		<table>
			<tr>
				<td colspan="">
                                            <!-- finger_print Match -->
                                            <input type="hidden" id="txtIsoTemplate" name="fingerdata" value="" class="form-control"/>
                                            <input type="hidden" value="" id="txtStatus" class="form-control hide" />
                                            <input type="hidden" value="" id="txtImageInfo" class="form-control" />
                                            <input type="hidden"id="txtIsoTemplate" name="txtIsoTemplate" value="" class="form-control"/>
                                            <input type="hidden" id="txtAnsiTemplate" class="form-control"/>
                                            <input type="hidden" id="txtIsoImage" class="form-control"/>
                                            <input type="hidden" id="txtRawData" class="form-control"/>
                                            <input type="hidden" id="txtWsqData" class="form-control"/>
    
                                            <!--<input type="submit" value="VerifyFinger" class="btn btn-success" onclick="return Match()" id="sub" />-->
                                            <button type="submit" class="btn btn-success" onclick="return Match()" id="sub" >Verify Finger</button>
                                         
                                            <!-- finger_print Match end -->
                                            <hr>
                                    </td>
			</tr>
		</table>
	
	</form>
	<script src="jquery-1.8.2.js"></script>
    <script src="mfs100-9.0.2.6.js"></script>
</body>
</html>