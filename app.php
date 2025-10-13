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
                <div class="modal fade" id="mainModalLg" tabindex="-1" aria-labelledby="mainModalLgLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title h4" id="mainModalLgLabel">Large modal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                        </div>
                    </div>
                </div>

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