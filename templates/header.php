<header>
    <div class="header-top">
        <div class="container">
            <!-- Логотип  -->
            <a href="index.html" class="logo">
                <img src="../images/logo.png">
            </a>

            <!-- Меню -->
            <div class="wrapper-nav">
                <!-- Кнопка меню -->
                <input class="side-menu" type="checkbox" id="side-menu" />
                <label class="hamb" for="side-menu">
                    <span class="hamb-line"></span>
                </label>
                <div class="inner-menu">
                    <nav class="nav">
                        <ul class="menu">
                            <?php
                            $current_page = $_SERVER['REQUEST_URI'];
                            $links = array(
                                '/' => array(
                                    'title' => 'Результаты',
                                    'image' => '../images/chart-svgrepo-com.svg'
                                ),
                                '/aut.php' => array(
                                    'title' => 'Вход в систему',
                                    'image' => '../images/unlock-svgrepo-com.svg'
                                ),
                                '/actions/logout.php' => array(
                                    'title' => 'Выход из системы',
                                    'image' => '../images/shield-vulnerable-svgrepo-com.svg'
                                )
                            );

                            foreach ($links as $link => $data) {
                                if($link == '/' && !isset($_SESSION['user'])) {
                                    continue;
                                }
                                if($link == '/actions/logout.php' && !isset($_SESSION['user'])) {
                                    continue;
                                }
                                if($link == '/aut.php' && isset($_SESSION['user'])) {
                                    continue;
                                }
                                if($current_page == $link) {
                                    $active = 'active';
                                } else{
                                    $active = '';
                                }
                                echo "<li><a class='$active' href='$link'>";
                                if (!empty($data['image'])) {
                                    echo "<img src='{$data['image']}' alt='{$data['title']}'>"; 
                                }
                                echo $data['title'];
                                echo "</a></li>";
                            }

                            ?>
                        </ul>
                    </nav>
                    <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['auth']) && $_SESSION['user']['auth'] === true): ?>
                    <div><a class="btn" href="test.php">Пройти тест</a></div>
                    <?php endif ?>
                </div>
            </div>

        </div>
    </div>

    <div class="header-content">
        <div class="container">

        </div>
    </div>

</header>









<!-- <header>
<div class="conteiner">
        <a class="logo" href="index.php"><img src="assets/img/Bloomify-logo.png"></a>
    <div class="menu">
            <div class="btn-menu"><img src='assets/img/4254068.png'></a></div>
            <div class="mein-nav">
                <div><a href="index.php">О нас</a></div>
                <div><a href="catalog.php">Каталог</a></div>
                <div><a href="to-find.php">Контакты</a></div>
            </div>
              <div class="additional-menu">
                    <?php
                    if ($_SESSION['user']['auth'] == true) {
                        echo "<div><a href='profile.php'><img src='assets/img/743131.png'><span>Корзина<span></a></div>
                        <div><a href='order.php'><img src='assets/img/3139110.png'><span>Заказы<span></a></div>
                       <div><a href='actions/logout.php'><img src='assets/img/149409.png'><span>Выход<span></a></div>";
                    } else {
                        echo "
                     <div><a href='autreg.php'><img src='assets/img/2321232.png'><span>Вход<span></a></div>";
                    }
                    ?>
              </div>
        
    </div>
</div>
</header> -->