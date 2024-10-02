<!--Offcanvas Menu start-->
<div class="offcanvas offcanvas-start bg-dark text-white sidebar-nav" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-body">
        <nav class="navbar-dark">
            <ul class="navbar-nav">
                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Core
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL ?>dashboard.php">
                        <i class="fas fa-tachometer-alt-fast me-2"></i> Dashboard</a>
                </li>
                <li class="my-0">
                    <hr />
                </li>


                <?php if($_SESSION['user']['isAdmin']) { ?>

                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Inventory
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#roomManagement" role="button" aria-expanded="false" aria-controls="booksManagement">
                        <i class="fa-solid fa-book me-2"></i>
                        Rooms Management
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="roomManagement">
                        <div>
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="<?php echo BASE_URL ?>rooms/add-room.php" class="nav-link"><i class="fa-solid fa-plus me-2"></i> Add New</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL ?>rooms/" class="nav-link"><i class="fa-solid fa-list me-2"></i> Manage All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#studentsManagement" role="button" aria-expanded="false" aria-controls="studentsManagement">
                        <i class="fa-solid fa-users me-2"></i>
                        Students
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="studentsManagement">
                        <div>
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="<?php echo BASE_URL ?>students/add-student.php" class="nav-link"><i class="fa-solid fa-plus me-2"></i> Add New</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL ?>students" class="nav-link"><i class="fa-solid fa-list me-2"></i> Manage All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="my-0">
                    <hr />
                </li>

                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Grivence
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#checkcomplaints" role="button" aria-expanded="false" aria-controls="booksManagement">
                        <i class="fa-solid fa-book me-2"></i>
                       Check Complaints
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="checkcomplaints">
                        <div>
                            <ul class="navbar-nav ps-3">
                    
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i> Manage All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </li>

                <li class="my-0">
                    <hr />
                </li>
                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Notice
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#noticemgmt" role="button" aria-expanded="false" aria-controls="booksManagement">
                        <i class="fa-solid fa-book me-2"></i>
                       Notice Management
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="noticemgmt">
                        <div>
                            <ul class="navbar-nav ps-3">
                    
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i>Add New Notice</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i> Manage All</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </li>

                <li class="my-0">
                    <hr />
                </li>

            <?php } else { ?>        

                <!-- For Students / users  -->
                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Inventory
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#roomManagement" role="button" aria-expanded="false" aria-controls="booksManagement">
                        <i class="fa-solid fa-book me-2"></i>
                        Apply For Hostel
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="roomManagement">
                        <div>
                            <ul class="navbar-nav ps-3">
                                <li>
                                    <a href="<?php echo BASE_URL ?>users/edit-student.php" class="nav-link"><i class="fa-solid fa-plus me-2"></i>Application Form</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL ?>users/view-application.php" class="nav-link"><i class="fa-solid fa-list me-2"></i> View Application Form</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            

                <li class="my-0">
                    <hr />
                </li>

                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Grivence
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#checkcomplaints" role="button" aria-expanded="false" aria-controls="booksManagement">
                        <i class="fa-solid fa-book me-2"></i>
                            Complaint Raise
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="checkcomplaints">
                        <div>
                            <ul class="navbar-nav ps-3">
                    
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i>Raise An Issue</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#noticemgmt" role="button" aria-expanded="false" aria-controls="booksManagement">
                        <i class="fa-solid fa-book me-2"></i>
                       Notice Management
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="noticemgmt">
                        <div>
                            <ul class="navbar-nav ps-3">
                    
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i>Check Notice</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                    
                </li>

                <li class="my-0">
                    <hr />
                </li>
                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Payment
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#feesManagement" role="button" aria-expanded="false" aria-controls="feesManagement">
                        <i class="fa-solid fa-book me-2"></i>
                       Fees Payment
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="feesManagement">
                        <div>
                            <ul class="navbar-nav ps-3">
                    
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i>Pay Hostel Fees</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i>Payment History</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </li>

                <li class="my-0">
                    <hr />
                </li>

                <li>
                    <div class="text-secondary small fw-bold text-uppercase">
                        Plans
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link sidebar-link" data-bs-toggle="collapse" href="#plansManagement" role="button" aria-expanded="false" aria-controls="plansManagement">
                        <i class="fa-solid fa-book me-2"></i>
                            Current Plans
                        <span class="right-icon float-end"><i class="fas fa-chevron-down"></i></span>
                    </a>

                    <div class="collapse" id="plansManagement">
                        <div>
                            <ul class="navbar-nav ps-3">
                    
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i>Active Plans</a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL ?>books/" class="nav-link"><i class="fa-solid fa-list me-2"></i>My Plan</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                </li>

                <li class="my-0">
                    <hr />
                </li>



            <?php } ?>    

                <li class="nav-item">
                    <a href="<?php echo BASE_URL ?>logout.php" class="nav-link"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!--Offcanvas Menu end-->