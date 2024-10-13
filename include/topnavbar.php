<!--Top Navbar Start-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <!--offcanvar trigger start-->
        <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!--offcanvar trigger start-->

        <a class="navbar-brand fw-bold text-uppercase me-auto" href="<?php echo BASE_URL ?>">Novelty Hostel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="d-flex ms-auto" role="search">
                <div class="input-group my-3 my-lg-0">
                    <input type="text" class="form-control" placeholder="Search" aria-describedby="button-addon2" />
                    <button class="btn btn-outline-secondary bg-primary text-white" type="button" id="button-addon2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>

            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo BASE_URL ?>assets/images/user.jpg" class="user-icon" />
                        <?php if(isset($_SESSION['user']['isAdmin']) && $_SESSION['user']['isAdmin']) { ?>
                            Hi Admin
                        <?php } else { ?>

                            <?php echo $_SESSION['user']['username'] ?>
                        <?php }?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo BASE_URL ?>users">My Profle</a></li>
                        <li><a class="dropdown-item" href="">Change Password</a></li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL ?>logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--Top Navbar End-->