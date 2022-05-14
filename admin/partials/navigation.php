<div class="main-panel">
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar bar1"></span>
                <span class="icon-bar bar2"></span>
                <span class="icon-bar bar3"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="ti-user"></i>
                            <p class="notification"></p>
                            <?php 
                                if (isset($_SESSION['username'])) {
                                    $username = $_SESSION['username'];

                                    echo "
                                        <p>$username</p>
                                    ";
                                }
                            ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                        <li><a href="logout.php"><i class="ti-power-off"></i> Log Out</a></li>
                        </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
