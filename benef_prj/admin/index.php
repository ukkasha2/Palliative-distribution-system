<?php
    // Include database connection file
    include '../includes/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
        const Swal = require('sweetalert2');
    </script>

    <style>
        /* Custom CSS for fixing sidebar and navbar */
        .fixed-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto; /* Enable vertical scrolling */
            z-index: 2; /* Ensure sidebar appears above other content */
            transition: all 0.5s ease;
        }

        .fixed-navbar {
            position: fixed;
            top: 0;
            left: 16rem; /* Adjust according to sidebar width */
            right: 0;
            z-index: 1; /* Ensure navbar appears above other content */
        }

        .main-content {
            margin-top: 6rem; /* Adjust according to navbar height */
            margin-left: 19rem; /* Adjust according to sidebar width */
            padding: 1rem;
            overflow-y: auto; /* Enable vertical scrolling for main content */
        }

        @media screen and (max-width: 916px) {
            .fixed-sidebar {
                left: -100rem;
                overflow-x: hidden;
            }

            .fixed-navbar {
                left: 0;
            }

            .main-content {
                margin-left: 1rem;
            }

            .sidebar {
                left: 0rem;
            }
        }
    </style>

    <title>PalliativeCare System Admin Dashboard</title>
</head>
<body class="bg-gray-200 font-sans">

    <!-- Sidebar -->
    <div class="flex h-screen">
        <div class="bg-gray-900 fixed-sidebar text-white w-80 lg:w-72 p-4 flex flex-col transition duration-2s ease-in" id="sidebar">
            <div class="mb-8">
                <div class="flex gap-8 items-center mb-4">
                    <div class="flex items-center">
                        <img src="https://via.placeholder.com/40" alt="Admin Logo" class="rounded-full mr-2">
                        <p class="text-lg font-bold lg:mb-2">PalliativeCare System</p>
                    </div>
                    <button class="block lg:hidden text-white text-xl" id="toggleSidebar1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="flex flex-col gap-3 items-center mb-4">
                    <img src="https://via.placeholder.com/100" alt="Admin Logo" class="rounded-full mr-2">
                    <div class="flex flex-col gap-1 items-center mb-8">
                        <p class="text-lg font-semibold">Ukasha Aminu Aliyu</p>
                        <p class="text-sm">Administrator</p>
                    </div>
                </div>
                <div class="flex gap-0.5 m-2 mt-4 items-center">
                    <i class="fas fa-bars mr-3 text-md text-gray-400"></i>
                    <p class="text-md text-gray-300 font-semibold">MENU</p>
                </div>
                <ul class="ml-6">
                    <li class="flex items-center hover:bg-white hover:text-gray-900 p-2 m-0">
                        <i class="fas fa-home mr-3 text-xl w-6"></i>
                        <a href="../admin" class="text-lg transition duration-300">
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center hover:bg-white hover:text-gray-900 p-2 m-0">
                        <i class="fas fa-users mr-3 text-xl w-6"></i>
                        <a href="?page=users" class="text-lg transition duration-300">
                            System Users
                        </a>
                    </li>
                    <li class="flex items-center hover:bg-white hover:text-gray-900 p-2 m-0">
                        <i class="fas fa-users mr-3 text-xl w-6"></i>
                        <a href="?page=manage_categories" class="text-lg transition duration-300">
                            Manage Categories
                        </a>
                    </li>
                </ul>
                <div class="flex gap-0.5 m-2 mt-4 items-center">
                    <i class="fas fa-users mr-3 text-md text-gray-400"></i>
                    <p class="text-md text-gray-300 font-semibold">BENEFICIARIES</p>
                </div>
                <ul class="ml-6">
                    <li class="flex items-center hover:bg-white hover:text-gray-900 p-2 m-0">
                        <i class="fas fa-user-check mr-3 text-xl w-6"></i>
                        <a href="?page=registered" class="text-lg transition duration-300">
                            Registered
                        </a>
                    </li>
                    <li class="flex items-center hover:bg-white hover:text-gray-900 p-2 m-0">
                        <i class="fas fa-user-plus mr-3 text-xl w-6"></i>
                        <a href="?page=benefited" class="text-lg transition duration-300">
                            Benefited
                        </a>
                    </li>
                    <li class="flex items-center hover:bg-white hover:text-gray-900 p-2 m-0">
                        <i class="fas fa-hourglass-half mr-3 text-xl w-6"></i>
                        <a href="?page=yet_to_benefit" class="text-lg transition duration-300">
                            Yet to Benefit
                        </a>
                    </li>
                    <li class="flex items-center hover:bg-white hover:text-gray-900 p-2 m-0">
                        <i class="fas fa-user-plus mr-3 text-xl w-6"></i>
                        <a href="?page=verify_fingerprint" class="text-lg transition duration-300">
                            New Beneficiary
                        </a>
                    </li>
                </ul>                
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Navbar -->
            <div class="bg-blue-700 fixed-navbar text-white flex justify-between items-center p-4 mb-8">
                <div class="flex items-center lg:opacity-0">
                    <button class="block lg:hidden ml-auto mr-4 text-white text-xl" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <img src="https://via.placeholder.com/40" alt="Admin Profile" class="rounded-full mr-2">
                    <p class="text-lg font-semibold">Admin Name</p>
                </div>
                <div class="relative">
                    <button class="text-white">
                        <i class="fas fa-cog"></i>
                    </button>
                    <!-- Dropdown Menu -->
                    <ul class="absolute w-44 flex flex-col gap-2 right-0 p-1 mt-5 bg-white border rounded-md shadow-lg hidden">
                        <li class="hover:bg-gray-100 p-1">
                            <a class="text-gray-600 flex items-center" href="#">
                                <i class="fas fa-lock mr-2"></i>
                                Change Password
                            </a>
                        </li>
                        <li class="hover:bg-gray-100 p-1 border-t-2">
                            <a class="text-gray-600 flex items-center" href="#">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white main-content p-4 m-4 rounded-md shadow-md">
                <?php 
                    if(isset($_GET['page'])) {
                        $page = $_GET['page'];
                        include('./pages/'.$page.''.'.php');
                    } else {
                        ?>
                            <!-- Statistics Container -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                                    <!-- Statistic Cards -->
                                    <a href="#" class="flex flex-col items-center bg-blue-200 p-6 rounded-md mx-2 hover:bg-blue-300">
                                        <i class="fas fa-users text-3xl mb-2"></i>
                                        <p class="text-lg font-semibold">System Users</p>
                                        <p class="text-xl font-bold">10</p>
                                    </a>
                                    <a href="#" class="flex flex-col items-center bg-green-200 p-6 rounded-md mx-2 hover:bg-green-300">
                                        <i class="fas fa-user-check text-3xl mb-2"></i>
                                        <p class="text-lg font-semibold">Beneficiaries</p>
                                        <p class="text-xl font-bold">300</p>
                                    </a>
                                    </div>
                            <div class="flex flex-col items-center justify-center">
                                <canvas class="mt-12" id="myChart" style="width:100%; max-width:800px; height:400px;"></canvas>
                                <canvas class="mt-12" id="myBarChart" style="width:100%; max-width:800px; height:400px;"></canvas>
                            </div>                
                            <script>
                                 const xValues = ["Registered", "Benifited", "Yet to Benefit"];
                                 const yValues = [55, 25, 30];
                                 const barColors = [
                                   "#b91d47",
                                   "#00aba9",
                                   "#2b5797"
                                 ];
                             
                                new Chart("myChart", {
                                    type: "pie",
                                    data: {
                                    labels: xValues,
                                    datasets: [{
                                       backgroundColor: barColors,
                                       data: yValues
                                     }]
                                   },
                                    options: {
                                    title: {
                                        display: true,
                                        text: "PalliativeCare System Statistics"
                                        }
                                    }
                                     });

                                    const labels = ["Zamfara", "Zamfara", "Zamfara", "Zamfara", "Zamfara", "Zamfara", "Kebbi"];
                                    const data = {
                                      labels: labels,
                                      datasets: [{
                                        label: 'Beneficiaries',
                                        data: [65, 59, 80, 81, 56, 55, 40, 75],
                                        backgroundColor: [
                                          'rgba(255, 99, 132, 0.2)',
                                          'rgba(255, 159, 64, 0.2)',
                                          'rgba(255, 205, 86, 0.2)',
                                          'rgba(75, 192, 192, 0.2)',
                                          'rgba(54, 162, 235, 0.2)',
                                          'rgba(153, 102, 255, 0.2)',
                                          'rgba(201, 203, 207, 0.2)',
                                          'rgba(255, 159, 64, 0.2)'
                                        ],
                                        borderColor: [
                                          'rgb(255, 99, 132)',
                                          'rgb(255, 159, 64)',
                                          'rgb(255, 205, 86)',
                                          'rgb(75, 192, 192)',
                                          'rgb(54, 162, 235)',
                                          'rgb(153, 102, 255)',
                                          'rgb(201, 203, 207)',
                                          'rgb(255, 159, 64)'
                                        ],
                                        borderWidth: 1
                                      }]
                                    };
                                    
                                    new Chart("myBarChart", {
                                        type: 'bar',
                                        data: data,
                                        options: {
                                            title: {
                                                display: true,
                                                text: "Statistics by Local Gov'ts"
                                            },
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        },
                                    });
                                </script>
                            </div>
                        <?php
                    }
                ?>
        </div>
    </div>

    <script>
        // Add JavaScript for handling dropdown menu toggle
        document.addEventListener('DOMContentLoaded', function () {
            var dropdownBtn = document.querySelector('.relative button');
            var dropdownMenu = document.querySelector('.relative ul');

            dropdownBtn.addEventListener('click', function () {
                dropdownMenu.classList.toggle('hidden');
            });

            window.addEventListener('click', function (event) {
                if (!dropdownBtn.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // JavaScript for toggling sidebar on mobile devices
            var toggleSidebarBtn = document.querySelector('#toggleSidebar');
            var sidebar = document.querySelector('#sidebar');

            toggleSidebarBtn.addEventListener('click', function () {
                sidebar.classList.toggle('sidebar');
            });

            var toggleSidebarBtn = document.querySelector('#toggleSidebar1');
            var sidebar = document.querySelector('#sidebar');

            toggleSidebarBtn.addEventListener('click', function () {
                sidebar.classList.remove('sidebar');
            });
        });
    </script>

    <!-- Charts JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> 

    <!-- Fingerprint JS -->
    <script src="./mfs100-9.0.2.6.js"></script>

     <!-- Fingerprint JS -->
    <script src="./jquery-1.8.2.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- JQuery -->
    <script src="./jquery.min.js"></script> 

</body>
</html>