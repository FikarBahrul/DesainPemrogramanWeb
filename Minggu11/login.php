<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include "fungsi/pesan_kilat.php";
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>Aplikasi Kantor Devon Grade</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/sign-in/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="icon" href="assets/img/favicons/favicon.ico">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }
    
    .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .btn-bd-primary {
        --bd-violet: #712cf9;
        --bd-violet-rgb: 113, 44, 249;
        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet);
        --bs-btn-border-color: var(--bd-violet);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
    }

    .bd-mode-toggle {
        z-index: 1500;
    }

    .bd-mode-toggle .dropdown-menu .active .btn {
        display: block !important;
    }
    </style>
    <link href="assets/custom/sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check2" viewBox="0 0 16 16">
            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
        </symbol>
        <symbol id="circle-half" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
        </symbol>
        <symbol id="moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278A.768.768 0 0 1 7 .808v1.23a.768.768 0 0 1-.857.761 7.218 7.218 0 0 0-.256.024 7.279 7.279 0 0 1 3.468 3.42 7.26 7.26 0 0 1 3.844 5.27.768.768 0 0 1 .797.778 7.218 7.218 0 0 0 .777.208.768.768 0 0 1-.223 1.346 7.279 7.279 0 0 1-5.69 0c-.16-.046-.317-.1-.47-.16-.27-.11-.53-.23-.78-.36l-.01-.01-.01-.01-.01-.01-1.39-1.39-1.25-.94 1.15-.92-1.15-.92-1.25-.94-1.39-1.39c-.25-.13-.51-.25-.78-.36-.15-.06-.31-.11-.47-.16-.77-.28-1.55-.42-2.34-.42a7.279 7.279 0 0 1-5.69 0 7.218 7.218 0 0 0-.256-.024.768.768 0 0 1-.857-.761V.808A.768.768 0 0 1 6 .278z"/>
        </symbol>
        <symbol id="sun-fill" viewBox="0 0 16 16">
            <path d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2a.5.5 0 0 1 .5-.5zM2.5 7.5A.5.5 0 0 1 3 8h2a.5.5 0 0 1 0-1H3a.5.5 0 0 1-.5.5zm10 0a.5.5 0 0 1 .5.5h2a.5.5 0 0 1 0-1h-2a.5.5 0 0 1-.5.5zM6 3.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zM6 12.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zM3.5 6a.5.5 0 0 1 0 1.07l-1.07 1.07a.5.5 0 0 1-.708-.708l1.07-1.07A.5.5 0 0 1 3.5 6zm9 0a.5.5 0 0 1 0 1.07l-1.07 1.07a.5.5 0 0 1-.708-.708l1.07-1.07A.5.5 0 0 1 12.5 6zm-9 6a.5.5 0 0 1 0 1.07l1.07 1.07a.5.5 0 0 1-.708.708l-1.07-1.07A.5.5 0 0 1 3.5 12zm9 0a.5.5 0 0 1 0 1.07l1.07 1.07a.5.5 0 0 1-.708.708l-1.07-1.07A.5.5 0 0 1 12.5 12z"/>
        </symbol>
    </svg>

    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">
        <button class="btn btn-bd-primary dropdown-toggle d-flex align-items-center"
            id="bd-theme"
            type="button"
            aria-expanded="false"
            data-bs-toggle="dropdown"
            data-bs-display="static"
            aria-label="Toggle theme (auto)">
            <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"/></svg>
            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"/></svg>
                    Light
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"/></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"/></svg>
                    Dark
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"/></svg>
                </button>
            </li>
            <li>
                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">
                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"/></svg>
                    Auto
                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"/></svg>
                </button>
            </li>
        </ul>
    </div>
    
    <main class="form-signin w-100 m-auto">
        <form action="cek_login.php" method="post">
            <img class="mb-4" src="assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Silahkan login</h1>

            <?php if (isset($_SESSION['flashdata'])) {
                foreach ($_SESSION['flashdata'] as $key => $val) {
                    echo get_flashdata($key);
                }
            } ?>

            <div class="form-floating">
                <input type="text" class="form-control" name="username" id="floatingInput" placeholder="Username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Masuk</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017-2023</p>
        </form>
    </main>

    <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>