<?php 
$page =  basename($_SERVER['PHP_SELF']);
?>
<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3 overflow-hidden">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"></i>Dashboard</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="https://w0.peakpx.com/wallpaper/666/961/HD-wallpaper-anime-jujutsu-kaisen-satoru-gojo.jpg" alt=""
                    style="width: 40px; height: 40px;background:#E4221F;">
                <div
                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0"><?php echo $_SESSION['username']?></h6>
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="<?php echo $uri ?>dashboard.php"
                class="nav-item nav-link <?php if($page == "dashboard.php"){echo "active";}?>">
                <i class="fa fa-tachometer-alt me-2"></i>
                Dashboard
            </a>

            <a href="<?php echo $uri ?>/visitors.php"
                class="nav-item nav-link <?php if($page == "visitors.php"){echo "active";}?>">
                <i class="fas fa-person-booth me-2"></i>
                Visitors
            </a>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle <?php if($page == "add_project.php" OR $page == "view_projects.php"){echo "active";}?>"
                    data-bs-toggle="dropdown">
                    <i class="fas fa-book"></i> Projects
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0  <?php if($page == "add_project.php" OR $page == "view_projects.php"){echo "show";}?>">
                    <a href="<?php echo $uri ?>projects/add_project.php"
                        class="dropdown-item <?php if($page == "add_project.php"){echo "text-primary";}?>">
                        Add Project
                    </a>
                    <a href="<?php echo $uri ?>projects/view_projects.php"
                        class="dropdown-item <?php if($page == "view_projects.php"){echo "text-primary";}?>">
                        View Projects
                    </a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle  <?php if($page == "add_skill.php" OR $page == "view_skills.php"){echo "active";}?>"
                    data-bs-toggle="dropdown">
                    <i class="fa fa-brain me-2"></i> Skills
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 <?php if($page == "add_skill.php" OR $page == "view_skills.php"){echo "show";}?>">
                    <a class="dropdown-item <?php if($page == "add_skill.php"){echo "text-primary";}?>" href="<?php echo $uri ?>skills/add_skill.php">Add Skill</a>
                    <a href="<?php echo $uri ?>skills/view_skills.php"
                        class="dropdown-item <?php if($page == "view_skills.php"){echo "text-primary";}?>">View
                        Skills</a>
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#"
                    class="nav-link dropdown-toggle <?php if($page == "profile.php" OR $page == "about.php"){ echo "active";}?>"
                    data-bs-toggle="dropdown">
                    <i class="fas fa-user me-2"></i> Profile
                </a>
                <div
                    class="dropdown-menu bg-transparent border-0 <?php if($page == "profile.php" OR $page == "about.php" OR $page == "education.php" OR $page == "services.php" OR $page == "experience.php"){ echo "show";}?>">
                    <a href="<?php echo $uri ?>profile/profile.php"
                        class="dropdown-item <?php if($page == "profile.php"){echo "text-primary";}?>"> Profile </a>
                    <a href="<?php echo $uri ?>profile/about.php"
                        class="dropdown-item <?php if($page == "about.php"){echo "text-primary";}?>"> About Me </a>
                    <a href="<?php echo $uri ?>profile/services.php"
                        class="dropdown-item <?php if($page == "services.php"){echo "text-primary";}?>"> Services </a>
                    <a href="<?php echo $uri ?>profile/experience.php"
                        class="dropdown-item <?php if($page == "experience.php"){echo "text-primary";}?>"> Experience </a>
                    <a href="<?php echo $uri ?>profile/education.php"
                        class="dropdown-item <?php if($page == "education.php"){echo "text-primary";}?>"> Education </a>
                </div>
            </div>
            <a href="<?php echo $uri ?>settings.php"
                class="nav-item nav-link <?php if($page == "settings.php"){echo "active";}?>">
                <i class="fa fa-cog me-2"></i> Settings
            </a>
            <a href="<?php echo $uri ?>trash.php"
                class="nav-item nav-link <?php if($page == "trash.php"){echo "active";}?>">
                <i class="fas fa-trash me-2"></i>
                Trash
            </a>
            <a href="<?php echo $uri ?>profile/profile.php" class="nav-item nav-link">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>

        </div>
    </nav>
</div>
<!-- Sidebar End -->