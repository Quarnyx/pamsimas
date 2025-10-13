<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    include __DIR__ . '/partials/title-meta.php';
    include __DIR__ . '/partials/head-css.php';
    ?>
</head>

<body>

    <div class="app-wrapper">
        <?php
        include __DIR__ . '/partials/menu.php';
        ?>

        <!-- Start right Content here -->
        <div class="page-content">

            <!-- Start Container Fluid -->
            <div class="container-fluid">
                <?php
                include __DIR__ . '/web.php';
                ?>


            </div>
            <!-- End Container Fluid -->
            <?php
            include __DIR__ . '/partials/footer.php';
            ?>

        </div>
        <!-- End Page Content -->

    </div>
    <?php
    include __DIR__ . '/partials/vendor-scripts.php';
    ?>

    <!-- Vector Map Js -->
    <script src="assets/vendor/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/vendor/jsvectormap/maps/world-merc.js"></script>
    <script src="assets/vendor/jsvectormap/maps/world.js"></script>

    <!-- Dashboard Js -->
    <script src="assets/js/pages/dashboard.js"></script>

</body>

</html>