<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="title-panel">
            <p>Admin Panel</p>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

            <li <?php if ($page == 'admin_ticker') echo "class=\"active\""; ?>>
                <a href="<?php echo site_url("admin/view/admin_ticker"); ?>">
                    <i class="fa fa-pencil-square"></i> <span>Setting for Ticker</span>
                </a>
            </li>

            <li <?php if ($page == 'admin_voting') echo "class=\"active\""; ?>>
                <a href="<?php echo site_url("admin/view/admin_voting"); ?>">
                    <i class="fa fa-pencil-square"></i> <span>Setting for Voting</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>