
    <style>
        /* Customize the thumb thumbnail */
        .thumb {
            width: 300px; /* Adjust as needed */
            height: 300px; /* Adjust as needed */
            margin-bottom: 20px;
        }

        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.5); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

         /* Close button */
         .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <div class="container mx-auto py-8 text-center flex flex-col justify-center items-center">
        <h1 class="text-2xl font-bold mb-4">Fingerprint Verification</h1>
        <form action="" method="POST">
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
                     
                    <!-- finger_print Match end -->
                    <hr>
                </td>
            </tr>
            <tr>
              <td >
                <img src="../assets/images/fingerprint.png" id="imgFinger" alt="Finger Image" class="w-64 h-64 border-2 border-blue-500 p-2 mb-3" />
				</td>
            </tr>
            <tr>
            <td class="mt-2">
			    <input type="submit" value="Capture" name="enroll-finger" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="return Capture()" id="sub" />
			    <input type="submit" value="Verify Fingerprint" name="enroll-finger" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded hidden" onclick="return Match()" id="verifyFinger" />
            </td> 
            </tr>
            </table>
          </form>
    </div>

     <!-- Modal for Fingerprint Scanning -->
     <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

<?php

// Function to fetch all fingerprints from the database
function fetchAllFingerprints($connection) {
    $fingerprints = array();
    $sql = "SELECT fingerprint_template FROM users_fingerprints";
    $result = mysqli_query($connection, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $fingerprints[] = $row['fingerprint_template'];
        }
    }
    return $fingerprints;
}


$fingerprints = fetchAllFingerprints($connection);
?>
<script language="javascript" type="text/javascript">

var quality = 60; // (1 to 100) (recommanded minimum 55)
var timeout = 10; // seconds (minimum=10(recommanded), maximum=60, unlimited=0

function Capture() {
    try {
        document.getElementById('txtStatus').value = "";
        document.getElementById('imgFinger').src = "data:image/bmp;base64,";
        document.getElementById('txtImageInfo').value = "";
        document.getElementById('txtIsoTemplate').value = "";
        document.getElementById('txtAnsiTemplate').value = "";
        document.getElementById('txtIsoImage').value = "";
        document.getElementById('txtRawData').value = "";
        document.getElementById('txtWsqData').value = "";

        var res = CaptureFinger(quality, timeout);
        if (res.httpStaus) {
            document.getElementById('txtStatus').value = "ErrorCode: " + res.data.ErrorCode + " ErrorDescription: " + res.data.ErrorDescription;

            if (res.data.ErrorCode == "0") {
                document.getElementById('imgFinger').src = "data:image/bmp;base64," + res.data.BitmapData;
                var imageinfo = "Quality: " + res.data.Quality + " Nfiq: " + res.data.Nfiq + " W(in): " + res.data.InWidth + " H(in): " + res.data.InHeight + " area(in): " + res.data.InArea + " Resolution: " + res.data.Resolution + " GrayScale: " + res.data.GrayScale + " Bpp: " + res.data.Bpp + " WSQCompressRatio: " + res.data.WSQCompressRatio + " WSQInfo: " + res.data.WSQInfo;
                document.getElementById('txtImageInfo').value = imageinfo;
                document.getElementById('txtIsoTemplate').value = res.data.IsoTemplate;
                document.getElementById('txtAnsiTemplate').value = res.data.AnsiTemplate;
                document.getElementById('txtIsoImage').value = res.data.IsoImage;
                document.getElementById('txtRawData').value = res.data.RawData;
                document.getElementById('txtWsqData').value = res.data.WsqImage;
                document.getElementById('verifyFinger').classList.remove('hidden');
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

function Match() {
    try {
        var isotemplates = <?php echo json_encode($fingerprints); ?>; // Pass fetched fingerprints to JavaScript
        var scannedFingerprint = document.getElementById('txtIsoTemplate').value;

        var matchFound = false;
        for (var i = 0; i < isotemplates.length; i++) {
            var res = VerifyFinger(scannedFingerprint, isotemplates[i]);
            if (res.httpStaus && res.data.Status) {
                matchFound = true;
                break;
            }
        }

        if (matchFound) {
            Swal.fire({
                    icon: 'success',
                    title: 'Fingerprint Verified!',
                    text: 'This user is already registered! Do you want to view his profile?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, View!'
                }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '?page=beneficiary_information&user_id=';
                        } else {
                            window.location.href = '?page=verify_fingerprint';
                        }
                });
        } else {
            setFingerprintSession(scannedFingerprint);
            Swal.fire({
                    icon: 'success',
                    title: 'Fingerprint Verified!',
                    text: 'This user is not yet registered! Do you want to enroll him?',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continue!'
                }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '?page=new_beneficiary';
                        } else {
                            window.location.href = '?page=verify_fingerprint';
                        }
                });
        }
    } catch (e) {
        alert(e);
    }
    return false;
}

function setFingerprintSession(fingerprintTemplate) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'set_session.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                console.log('Session variable set successfully');
            } else {
                console.log('Failed to set session variable');
            }
        } else {
            console.error('Request failed');
        }
    };
    xhr.send('fingerprint_template=' + fingerprintTemplate);
}
</script>


