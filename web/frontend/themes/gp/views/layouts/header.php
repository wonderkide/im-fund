<?php 
use yii\helpers\Html;
?>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top main-nav-menu">
    <div class="container d-flex align-items-center justify-content-between">

        <h1 class="logo"><a href="/">FUND<span>.</span></a></h1>

        <nav class="nav-menu d-none d-lg-block">
            <ul>
                <li class="active"><a href="/">Home</a></li>
                <?php if(!Yii::$app->user->isGuest): ?>
                <li><a href="/fund/index">Fund</a></li>
                <?php endif; ?>
                <?php /*
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#team">Team</a></li>
                 * 
                 */
                ?>
                <?php /*
                <li class="drop-down"><a href="">Drop Down</a>
                  <ul>
                    <li><a href="#">Drop Down 1</a></li>
                    <li class="drop-down"><a href="#">Deep Drop Down</a>
                      <ul>
                        <li><a href="#">Deep Drop Down 1</a></li>
                        <li><a href="#">Deep Drop Down 2</a></li>
                        <li><a href="#">Deep Drop Down 3</a></li>
                        <li><a href="#">Deep Drop Down 4</a></li>
                        <li><a href="#">Deep Drop Down 5</a></li>
                      </ul>
                    </li>
                    <li><a href="#">Drop Down 2</a></li>
                    <li><a href="#">Drop Down 3</a></li>
                    <li><a href="#">Drop Down 4</a></li>
                  </ul>
                </li>
                <li><a href="#contact">Contact</a></li>
                 * 
                 */
                ?>

            </ul>
        </nav><!-- .nav-menu -->

        <?php if(Yii::$app->user->isGuest): ?>
        <a class="get-started-btn scrollto cd-signin cursor-pointer" data-target="#SignModal" id="modal-sign">Login / Signup</a>
        <?php else: ?>
        <?= Html::a('Logout', ['/site/logout'], ['data-method' => 'post', 'class' => 'get-started-btn scrollto']) ?>
        <?php endif; ?>

    </div>
</header><!-- End Header -->