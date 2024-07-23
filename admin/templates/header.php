<header>
    <div class="header-top">
        <div class="container">
            <!-- Логотип  -->
            <a href="index.php" class="logo">
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
                            // Получаем текущий URL
                            $current_page = $_SERVER['REQUEST_URI'];
                            $links = array(
                                '/admin/results.php' => array(
                                    'title' => 'Результаты',
                                    'image' => '../images/chart-svgrepo-com.svg'
                                ),
                                '/admin/index.php' => array(
                                    'title' => 'Тесты',
                                    'image' => '../images/text-svgrepo-com.svg'
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
                </div>
            </div>

        </div>
    </div>

    <div class="header-content">
        <div class="container">

        </div>
    </div>

</header>


