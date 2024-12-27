<aside class="main-sidebar sidebar-dark-secondary elevation-4">
    <!-- Sidebar header with conditional display for Admin/User -->
    <div class="dropdown">
        <a href="./" class="brand-link d-flex align-items-center justify-content-center">
            <img src="assets/images/logo.png" alt="lmao" style="width:40px; height:40px;">
            <!-- <?php if($_SESSION['login_type'] == 1): ?>
                <p class="text-center p-0 m-0"><b>ADMIN</b></p>
            <?php else: ?>
                <p class="text-center p-0 m-0"><b>USER</b></p>
            <?php endif; ?> -->
        </a>
    </div>
    
    <!-- Sidebar content with enhanced style -->
    <div class="sidebar pb-4 mb-4">
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false"> 
                
                <!-- Dashboard Link -->
                <li class="nav-item dropdown">
                    <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-gamepad"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- Projects Section -->
                <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_project nav-view_project">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Projects
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <!-- Sub menu for Projects -->
                    <ul class="nav nav-treeview">
                        <?php if ($_SESSION['login_type'] != 3) : ?>
                            <li class="nav-item">
                                <a href="./index.php?page=new_project" class="nav-link nav-new_project tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="./index.php?page=project_list" class="nav-link nav-project_list tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Tasks Link -->
                <li class="nav-item">
                    <a href="./index.php?page=task_list" class="nav-link nav-task_list">
                        <i class="fas fa-tasks nav-icon"></i>
                        <p>Task</p>
                    </a>
                </li>

                <!-- Report Link (Only for non-regular users) -->
                <?php if($_SESSION['login_type'] != 3): ?>
                    <li class="nav-item">
                        <a href="./index.php?page=reports" class="nav-link nav-reports">
                            <i class="fas fa-th-list nav-icon"></i>
                            <p>Report</p>
                        </a>
                    </li>
                <?php endif; ?>

                <!-- User Management (Admin Only) -->
                <?php if($_SESSION['login_type'] == 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_user">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="right fas fa-angle-right"></i>
                            </p>
                        </a>
                        <!-- Sub-menu for Users -->
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>

<!-- Sidebar behavior script -->
<script>
    $(document).ready(function(){
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
        if(s!='')
            page = page+'_'+s;
        
        if($('.nav-link.nav-'+page).length > 0){
            $('.nav-link.nav-'+page).addClass('active');
            if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
                $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active');
                $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open');
            }
            if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
                $('.nav-link.nav-'+page).parent().addClass('menu-open');
            }
        }
    });
</script>

<!-- Enhanced CSS for sidebar -->
<style>
    .main-sidebar {
        background-color: #1f1f1f; /* Dark, modern color */
    }

    .nav-link {
        color: #ecf0f1; /* Light text for better contrast */
        transition: all 0.3s ease; /* Smooth transitions */
    }

    .nav-link:hover {
        background-color: #2980b9; /* Hover effect for better interaction */
        color: #fff;
    }

    .nav-icon {
        margin-right: 8px; /* Space between icon and text */
        font-size: 1.2em;
    }

    .nav-pills .nav-item > .nav-link.active {
        background-color: #2980b9; /* Highlight active items */
        color: white;
    }

    .nav-treeview {
        margin-left: 10px; /* Indentation for nested menus */
    }

    .tree-item {
        padding-left: 1.5rem; /* Indent tree view items */
    }

    .nav-icon.fas.fa-angle-left {
        transition: transform 0.2s ease;
    }

    .menu-open .fas.fa-angle-left {
        transform: rotate(-90deg); /* Rotate icon when menu is open */
    }
</style>
