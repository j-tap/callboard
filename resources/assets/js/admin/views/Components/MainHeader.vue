<template>
    <header class="main-header">
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">b<b>2</b>b</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b>b2b</span>
        </a>
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/images/admin/avatar.png" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{getUserName}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/images/admin/avatar.png" class="img-circle" alt="User Image">
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="/logout"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>
<script>
    export default {
        name: "MainHeader",
        computed: {
            getUserName() {
                return this.$root.profile.user.name;
            }
        }
    }
</script>

<style scoped>

</style>
