<?php

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $full_name = $_POST["full_name"];
    $local_govt = $_POST["local_govt"];
    $ward = $_POST["ward"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $account_name = $_POST["account_name"];
    $bank_name = $_POST["bank_name"];
    $account_number = $_POST["account_number"];
    $nin = $_POST["nin"];

    // File upload handling
    $target_dir = "../uploads/";
    $profile_pic = $target_dir . basename($_FILES["profile_pic"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($profile_pic,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($profile_pic)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_pic"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Insert beneficiary data into tbl_beneficiaries if file upload was successful
    if ($uploadOk) {
        // Insert beneficiary data into tbl_beneficiaries
        $sql = "INSERT INTO tbl_beneficiaries (user_id, full_name, local_govt, ward, address, phone_number, account_name, bank_name, account_number, nin, profile_pic) 
                VALUES ('', '$full_name', '$local_govt', '$ward', '$address', '$phone_number', '$account_name', '$bank_name', '$account_number', '$nin', '$profile_pic')";
        if ($connection->query($sql) === TRUE) {
            // Get the last inserted ID
            $last_id = $connection->insert_id;

            // Insert fingerprint data into users_fingerprints
            // Assuming you have fingerprint data stored in $fingerprint variable
            $fingerprint = $_SESSION["fingerprint_template"];
            $sql = "INSERT INTO users_fingerprints (user_id, fingerprint_template) VALUES ('$last_id', '$fingerprint')";
            if ($connection->query($sql) === TRUE) {
                unset($_SESSION['fingerprint_template']);
                ?>
                    <script>
                Swal.fire({
                    icon: 'success',
                    title: 'New Beneficiary added successfully!',
                    showConfirmButton: true,
                    timer: 3000
                }).then(() => {
                    window.location.href = '?page=verify_fingerprint';
                });
            </script>
                <?php
            } else {
                echo "Error inserting fingerprint data: " . $connection->error;
            }
        } else {
            echo "Error inserting beneficiary data: " . $connection->error;
        }
    }
}

// Close connection
$connection->close();
?>

    <h1 class="text-2xl font-bold mt-8">Register New Beneficiary</h1>
    <div class="container mx-auto py-2 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white px-8 pt-6 mb-4">
            <!-- Beneficiary Registration Form -->
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Personal Information -->
                <div class="mb-4">
                    <h2 class="text-lg font-bold mb-2">Personal Information</h2>
                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Profile Image</label>
                        <input class="hidden" type="file" accept="image/*" id="image" name="profile_pic" capture="environment" onchange="previewImage(event)">
                        <div class="flex items-center justify-center w-32 h-32 bg-gray-200 border-dashed border-2 border-gray-400 rounded-lg cursor-pointer" id="imageSelect" onclick="document.getElementById('image').click()">
                            <span class="text-gray-500 text-center p-2">Click to upload or drag and drop an image here</span>
                        </div>
                        <img class="w-32 h-32 p-2 border-2 border-gray-400 rounded hidden" id="imagePreview" src="" alt="Image Preview">
                    </div>
                    <script>
                        function previewImage(event) {
                            const imagePreview = document.getElementById('imagePreview');
                            const imageSelect = document.getElementById('imageSelect');
                            const file = event.target.files[0];
                            const reader = new FileReader();
                            reader.onload = function() {
                                imagePreview.src = reader.result;
                                imagePreview.classList.remove('hidden');
                                imageSelect.classList.add('hidden');
                            }
                            reader.readAsDataURL(file);
                        }
                    </script>
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Full Name</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="full_name" type="text" placeholder="Enter full name">
                    </div>
                    <!-- Address -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="local_govt">Local Gov't</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="local_govt" type="text" placeholder="Enter address">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="ward">Ward</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="ward" type="text" placeholder="Enter address">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="address" type="text" placeholder="Enter address">
                    </div>
                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone Number</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="phone_number" type="tel" placeholder="Enter phone number">
                    </div>
                </div>
        </div>
        <div class="bg-white px-8 pt-6 mb-4">
            <!-- Account Information -->
                <div class="mb-4">
                    <h2 class="text-lg font-bold mb-2">Account Information</h2>
                    <!-- Account Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="account_name">Account Name</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="account_name" type="text" placeholder="Enter account name">
                    </div>
                    <!-- Bank Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="bank_name">Bank Name</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="bank_name" type="text" placeholder="Enter bank name">
                    </div>
                    <!-- Account Number -->
                    <div class="mb-10">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="account_number">Account Number</label>
                        <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="account_number" type="text" placeholder="Enter account number">
                    </div>
                    <!-- National ID Information -->
                    <div class="mt-4 mb-4">
                        <h2 class="text-lg font-bold mb-2">National ID Information</h2>
                        <!-- National ID Number -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nationalId">National ID Number</label>
                            <input class="w-full px-2 py-2 border rounded-md focus:outline-none focus:border-blue-500" name="nin" type="text" placeholder="Enter national ID number">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <input value="Submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
        </div>
    </form>
    </div>