<template>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">SB Admin</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <router-link to="/home" class="nav-link" exact>
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>

        <hr class="sidebar-divider">


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
               aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Users</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                 data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Users:</h6>
                    <router-link to="/" class="collapse-item" exact>
                        New User
                    </router-link>
                    <router-link to="/" class="collapse-item" exact>
                        Users
                    </router-link>
                </div>
            </div>
        </li>


        <hr class="sidebar-divider d-none d-md-block">


    </ul>
</template>
