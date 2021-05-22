<template>
    <div id="wrapper">

        <Sidebar></Sidebar>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <Header></Header>

                </nav>
                <!-- End of Topbar -->

                <router-view></router-view>

            </div>
            <!-- End of Main Content -->

            <Footer></Footer>
        </div>
        <!-- End of Content Wrapper -->

    </div>
</template>

<script>
    import Header from '../components/Header.vue'
    import Sidebar from '../components/Sidebar.vue'
    import Footer from '../components/Footer.vue'
    export default {
        components:{
            Header,
            Sidebar,
            Footer
        }
    }
</script>
