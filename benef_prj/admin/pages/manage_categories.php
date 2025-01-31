<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $category_name = $connection->real_escape_string($_POST['category_name']);
    
    // Check if category already exists
    $check_query = "SELECT * FROM tbl_categories WHERE category_name = '$category_name'";
    $result = $connection->query($check_query);
    if ($result->num_rows > 0) {
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Category already exists!',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = '?page=manage_categories';
            });
        </script>
        <?php
    } else {
        // Handle image upload
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["category_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Rename file to category name
        $target_file_ = $target_dir . $category_name . '.' . $imageFileType;

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["category_image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["category_image"]["tmp_name"], $target_file_)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["category_image"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Insert into database
        $sql = "INSERT INTO tbl_categories (category_name, category_image) VALUES ('$category_name', '$target_file_')";
        if ($connection->query($sql) === TRUE) {
            ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'New category created successfully',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = '?page=manage_categories';
                });
            </script>
            <?php
        } else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
}
?>



    <div class="container mx-auto py-8">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Manage Categories</h1>
        <!-- Form to add new category -->
        <form action="" method="POST" class="w-64 mb-4" enctype="multipart/form-data">
            <div class="flex flex-col mb-4">
                <label for="category" class="w-32 mb-2">Category Name:</label>
                <input type="text" id="category" name="category_name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 mb-4" required>
                <label for="image" class="w-32 mb-2">Category Image:</label>
                <input type="file" id="image" name="category_image" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:border-blue-500 mb-4" required>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add Category
                </button>
            </div>
        </form>
        <!-- Categories Grid -->
        <div class="grid grid-cols-3 gap-4">
            <!-- Fetch and display categories -->
            <?php
            // Fetch categories from database
            $sql = "SELECT * FROM tbl_categories";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="relative bg-white rounded-md shadow-lg overflow-hidden">
                            <img src="' . $row["category_image"] . '" alt="Category Image" class="h-32 w-32 mx-auto mt-4 mb-2 rounded-full">
                            <div class="text-center mb-4">' . $row["category_name"] . '</div>
                            <div class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-75 opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <button onclick="deleteRecord(' . $row['id'] . ')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                            </div>
                        </div>';
                }
            } else {
                echo "<div class='border border-gray-200 px-4 py-2'>No categories found</div>";
            }
            // Close connection
            $connection->close();
            ?>
        </div>
    </div>
</div>

<script>
    function deleteRecord(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "delete_category.php",
                    data: { delete_id: id },
                    success: function(response) {
                        // Display success message
                        Swal.fire(
                            'Deleted!',
                            'Category has been deleted.',
                            'success'
                        ).then((result) => {
                            location.reload();
                        });
                    }
                });
            }
        });
    }
</script>