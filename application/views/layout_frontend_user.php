<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="author" content="protc" />
        <meta name="description" content="">
        <!-- Document title -->
        <title>DEMO</title>
        <!-- Stylesheets & Fonts -->
        <?php include('css-javascript.php') ?>
        <link href="<?=base_url()?>assets/polo/js/plugins/components/bootstrap-datetimepicker/tempusdominus-bootstrap-4.css" rel="stylesheet">
        <script src="<?= base_url() ?>assets/polo/js/plugins/components/moment.min.js"></script>
        <script src="<?= base_url() ?>assets/polo/js/jquery.js"></script>
        <link rel="stylesheet" href="<?= base_url() ?>assets/polo/css/lightslider.css">
    </head>
    <body class="side-panel side-panel-static">
        <!-- Side Panel -->
        <div id="side-panel" class="text-center">
            <div id="close-panel">
                <i class="fa fa-times"></i>
            </div>
            <div class="side-panel-wrap">
                <div class="logo">
                    <a href="#"><img src="images/side-logo-light.png"></a>
                </div>
                <!--Navigation-->
                <div id="mainMenu" class="menu-onclick menu-vertical">
                    <div class="container">
                        <nav>
                            <ul>
                                <li><a href="<?=base_url()?>login">HOME</a></li>
                                <li><a href="<?=base_url()?>login/logout">LOGOUT</a></li>
                                <?php include('menu-frontend.php') ?>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--social icons-->
<!--                <div class="social-icons social-icons-border social-icons-light  social-icons-colored-hover text-center">
                    <ul>
                        <li class="social-facebook"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li class="social-twitter"><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li class="social-google"><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                        <li class="social-pinterest"><a href="#"><i class="fab fa-pinterest"></i></a></li>
                        <li class="social-vimeo"><a href="#"><i class="fab fa-vimeo"></i></a></li>
                    </ul>
                </div>-->
            </div>

        </div>
        <!-- Wrapper -->
        <div id="wrapper">
            <!-- Section --> 
            <section style="padding:35px 0 !important;min-height:500px;">
                <div class="container">
                    <!-- Modal Strips buttons -->
                    
                    <div class="row"><?php $this->load->view($content); ?></div>
                </div>
            </section>
            <?php include('footer.php') ?>
            <!-- end: Footer -->

        </div>
        <!-- end: Wrapper -->

        <!-- Go to top button -->
        <a id="goToTop"><i class="fa fa-angle-up top-icon"></i><i class="fa fa-angle-up"></i></a>

        
        <script src="<?= base_url() ?>assets/polo/js/plugins.js"></script>

        <!--Template functions-->
        <script src="<?= base_url() ?>assets/polo/js/functions.js"></script>
    </body>

</html>
<script type="text/javascript">
    $(document).ready(function() {
    });
</script>