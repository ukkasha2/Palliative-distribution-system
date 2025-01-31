<?php
// Get the beneficiary ID from the link parameter
if (isset($_GET['user_id'])) {
    $beneficiaryId = $_GET['user_id'];
}

// Fetch beneficiary information from the database
$sql = "SELECT * FROM tbl_beneficiaries WHERE user_id = ?";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $beneficiaryId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $beneficiary = $result->fetch_assoc();
    // Extract beneficiary information
    $fullName = $beneficiary['full_name'];
    $localGovt = $beneficiary['local_govt'];
    $ward = $beneficiary['ward'];
    $address = $beneficiary['address'];
    $phoneNumber = $beneficiary['phone_number'];
    $accountName = $beneficiary['account_name'];
    $bankName = $beneficiary['bank_name'];
    $accountNumber = $beneficiary['account_number'];
    $nin = $beneficiary['nin'];
    $status = $beneficiary['status'];
    $profilePic = $beneficiary['profile_pic'];
    $registeredBy = $beneficiary['registered_by'];
    $dateCreated = $beneficiary['date_created'];
} else {
    // Handle case when beneficiary is not found
    echo "Beneficiary not found";
}
$stmt->close();
?>


<h1 class="text-2xl font-bold p-6">Beneficiary Information</h1>
    <div class="container mx-auto py-2 grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white px-8 mb-4">
            <!-- Beneficiary Registration Form -->
            <form>
                <!-- Personal Information -->
                <div class="mb-4">
                    <h2 class="text-lg font-bold mb-2">Personal Information</h2>
                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Profile Image</label>
                        <img class="w-32 h-32 p-2 border-2 border-gray-400 rounded" id="imagePreview" src="<?php echo $profilePic ?>" alt="Image Preview">
                    </div>
                    <!-- Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Full Name</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $fullName ?></span>
                    </div>
                    <!-- Address -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Local Gov't</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $localGovt ?></span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Ward</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $ward ?></span>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="address">Address</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $address ?></span>
                    </div>
                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone Number</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $phoneNumber ?></span>
                    </div>
                </div>
        </div>
        <div class="bg-white px-8 pt-6 mb-4">
            <!-- Account Information -->
                <div class="mb-4">
                    <h2 class="text-lg font-bold mb-2">Account Information</h2>
                    <!-- Account Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="accountName">Account Name</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $accountName ?></span>
                    </div>
                    <!-- Bank Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="bankName">Bank Name</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $bankName ?></span>
                    </div>
                    <!-- Account Number -->
                    <div class="mb-10">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="accountNumber">Account Number</label>
                        <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $accountNumber ?></span>
                    </div>
                    <!-- National ID Information -->
                    <div class="mt-4 mb-4">
                        <h2 class="text-lg font-bold mb-2">National ID Information</h2>
                        <!-- National ID Number -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="nationalId">National ID Number</label>
                            <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $nin ?></span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h2 class="text-lg font-bold mb-2">Status</h2>
                            <?php if ($status === 'Yet to Benefit'): ?>
                                <span class="w-full text-gray-600 px-2 py-2" id="address"><?php echo $status ?></span><br>
                                <button id="markAsBenefitedBtn" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Mark as Benefited</button>
                            <?php else: ?>
                                <span class="w-full text-gray-600 px-2 py-2" id="status"><?php echo $status; ?></span>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    // Function to handle marking beneficiary as benefited
    function markAsBenefited(beneficiaryId) {
        // Send AJAX request to update status
        fetch('/mark_as_benefited.php?beneficiary_id=' + beneficiaryId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to mark as benefited');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Beneficiary Marked as Benefited',
                    text: data.message,
                    showConfirmButton: true,
                }).then(() => {
                    history.back();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error.message,
                    showConfirmButton: true,
                });
            });
    }

    document.getElementById('markAsBenefitedBtn').addEventListener('click', function() {
        var beneficiaryId = <?php echo $beneficiaryId; ?>;
        markAsBenefited(beneficiaryId);
    });
</script>
