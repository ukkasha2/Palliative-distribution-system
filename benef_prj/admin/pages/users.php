
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Palliative Care System Users</h1>
        <!-- Flex container for search and button -->
        <div class="flex justify-between items-center mb-4">
            <!-- Search Bar -->
            <input type="text" id="searchInput" class="p-1.5 border border-gray-400 rounded-md mr-2" placeholder="Search for a user...">
            <!-- Add New User Button -->
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-3 rounded">
                <a href="?page=new_user">Add</a>
            </button>
        </div>
        <!-- Users Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="text-center py-2 px-3">S/N</th>
                        <th class="text-center py-2 px-3">Name</th>
                        <th class="text-center py-2 px-3">Username</th>
                        <th class="text-center py-2 px-3">Role</th>
                        <th class="text-center py-2 px-3">Date Created</th>
                        <th class="text-center py-2 px-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700" id="userTableBody">
                    <!-- User rows will be inserted here dynamically -->
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="flex gap-2 items-center mt-8 mx-auto">
            <button id="prevBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-2 mr-2 rounded" disabled>Prev</button>
            <div class="pagination" id="pagination"></div>
            <button id="nextBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-2 rounded">Next</button>
        </div>
    </div>

    <script>
    let users = [];

    const itemsPerPage = 7;
    let currentPage = 1;

    function displayUsers(page) {
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const usersToDisplay = users.slice(startIndex, endIndex);

        const tableBody = document.getElementById('userTableBody');
        tableBody.innerHTML = '';

        let sn = startIndex + 1;
        usersToDisplay.forEach(user => {
            const row = `
                <tr>
                    <td class="py-2 px-3">${sn++}</td>
                    <td class="py-2 px-3">${user.name}</td>
                    <td class="py-2 px-3">${user.username}</td>
                    <td class="py-2 px-3">${user.user_role == "1" ? "Admin" : "User"}</td>
                    <td class="py-2 px-3">${user.date_created}</td>
                    <td class="flex items-center py-2 px-3">
                        <a href="?page=edit_user&user_id=${user.id}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2">Edit</a>
                        <button onclick="deleteUser(${user.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    }

    function setupPagination() {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        const totalPages = Math.ceil(users.length / itemsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.innerText = i;
            button.addEventListener('click', () => {
                currentPage = i;
                displayUsers(currentPage);
                updatePaginationButtons();
            });
            pagination.appendChild(button);
        }

        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        const buttons = document.querySelectorAll('#pagination button');
        buttons.forEach((button, index) => {
            if (index + 1 === currentPage) {
                button.classList.add('bg-gray-600');
            } else {
                button.classList.remove('bg-gray-600');
            }
        });

        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (currentPage === 1) {
            prevBtn.disabled = true;
        } else {
            prevBtn.disabled = false;
        }

        if (currentPage === buttons.length) {
            nextBtn.disabled = true;
        } else {
            nextBtn.disabled = false;
        }
    }

    function searchUsers(query) {
        const filteredUsers = users.filter(user => {
            return user.name.toLowerCase().includes(query.toLowerCase()) ||
                user.username.toLowerCase().includes(query.toLowerCase()) ||
                user.user_role.toLowerCase().includes(query.toLowerCase());
        });
        displayUsers(1);
        currentPage = 1;
        setupPagination(filteredUsers);
    }

    document.getElementById('searchInput').addEventListener('keyup', (e) => {
        const query = e.target.value.trim();
        searchUsers(query);
    });

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            displayUsers(currentPage);
            updatePaginationButtons();
        }
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        const totalPages = document.querySelectorAll('#pagination button').length;
        if (currentPage < totalPages) {
            currentPage++;
            displayUsers(currentPage);
            updatePaginationButtons();
        }
    });

    async function fetchUsers() {
        try {
            const response = await fetch('fetch_users.php');
            if (!response.ok) {
                throw new Error('Failed to fetch users');
            }
            const data = await response.json();
            users = data;
            displayUsers(currentPage);
            setupPagination();
        } catch (error) {
            console.error(error);
        }
    }

    fetchUsers();

    function deleteUser(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "delete_user.php",
                    data: { delete_id: id },
                    success: function(response) {
                        // Display success message
                        Swal.fire(
                            'Deleted!',
                            'User has been deleted.',
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