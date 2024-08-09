<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
        <a href="./" class="brand-link">
            <?php if(isset($_SESSION['department_name'])): ?>
                <h3 class="text-center p-0 m-0"><b></b></h3>
            <?php endif; ?>
            <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
                <h3 class="text-center p-0 m-0"><b>MANAGER</b></h3>
            <?php elseif(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2): ?>
                <h3 class="text-center p-0 m-0"><b><?=$department_name; ?> HOD</b></h3>
            <?php else: ?>
                <h3 class="text-center p-0 m-0"><b><?=$department_name; ?> MEMBER</b></h3>
            <?php endif; ?>
        </a>
    </div>
    <div class="sidebar pb-4 mb-4">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item dropdown">
                    <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <!-- Projects -->
                <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_project nav-view_project">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>Projects <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if(isset($_SESSION['login_type']) && in_array($_SESSION['login_type'], [1, 2])): ?>
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
                <!-- Task -->
                <li class="nav-item">
                    <a href="./index.php?page=task_list" class="nav-link nav-task_list">
                        <i class="fas fa-tasks nav-icon"></i>
                        <p>Task</p>
                    </a>
                </li>
                <!-- Report -->
                <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] != 3): ?>
                    <li class="nav-item">
                        <a href="./index.php?page=reports" class="nav-link nav-reports">
                            <i class="fas fa-th-list nav-icon"></i>
                            <p>Report</p>
                        </a>
                    </li>
                <?php endif; ?>
                <!-- Users -->
                <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_user">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users <i class="right fas fa-angle-left"></i></p>
                        </a>
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
                <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_user">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.php?page=new_users" class="nav-link nav-new_user tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index.php?page=department_user" class="nav-link nav-user_list tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- Deligation -->
                <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_deligation">
                            <i class="nav-icon fas fa-share-alt"></i>
                            <p>Deligation <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- <li class="nav-item">
                                <a href="./index.php?page=deligations" class="nav-link nav-deligations tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Deligate task</p>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="./index.php?page=deligated_tasks" class="nav-link nav-deligated_tasks tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Deligations List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2 && $department_name == 'PLANNING'): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_deligation">
                            <i class="nav-icon fas fa-share-alt"></i>
                            <p>Stakeholders <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.php?page=stakeholders_list" class="nav-link nav-stakeholders tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Stakeholder List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index.php?page=new_stakeholder" class="nav-link nav-new_stakeholder tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Department -->
                <?php if(isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_department">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Department <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.php?page=new_department" class="nav-link nav-new_department tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index.php?page=department_list" class="nav-link nav-department_list tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <!-- Chat -->
                <?php if(isset($_SESSION['login_type']) && in_array($_SESSION['login_type'], [1, 2, 3])): ?>
                    <li class="nav-item <?php echo (isset($_GET['page']) && $_GET['page'] === 'chat') ? 'menu-open' : ''; ?>">
                        <a href="#" class="nav-link nav-edit_chat <?php echo (isset($_GET['page']) && $_GET['page'] === 'chat') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Chat <i class="right fas fa-angle-left"></i></p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if(isset($_SESSION['login_type']) && in_array($_SESSION['login_type'], [2, 3])): ?>
                                <li class="nav-item">
                                    <a href="./index.php?page=chat" class="nav-link nav-group_chat <?php echo (isset($_GET['page']) && $_GET['page'] === 'chat') ? 'active' : ''; ?>">
                                        <i class="fas fa-angle-right nav-icon"></i>
                                        <p>Group Chat</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="./index.php?page=homes" class="nav-link nav-private_chat <?php echo (isset($_GET['page']) && $_GET['page'] === 'homes') ? 'active' : ''; ?>">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Private Chat</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>

<script>
    $(document).ready(function(){
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
        if(s != '') page = page + '_' + s;
        if($('.nav-link.nav-' + page).length > 0){
            $('.nav-link.nav-' + page).addClass('active');
            if($('.nav-link.nav-' + page).hasClass('tree-item')){
                $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active');
                $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open');
            }
            if($('.nav-link.nav-' + page).hasClass('nav-is-tree')){
                $('.nav-link.nav-' + page).parent().addClass('menu-open');
            }
        }
    });
</script>
