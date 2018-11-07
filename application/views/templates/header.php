<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>NEW LPP</title>

    <!-- css -->
    <link rel="stylesheet" href="<?php echo base_url(VENDOR_PATH . 'Bootstrap/4.1.3/css/bootstrap.min.css'); ?>" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(VENDOR_PATH . 'DataTables/datatables.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url(ASSETS_PATH . '/css/custom.css'); ?>">

    <!-- script -->
    <script src="<?php echo base_url(VENDOR_PATH . 'jQuery/jquery-3.3.1.min.js'); ?>" crossorigin="anonymous"></script>
    <script src="<?php echo base_url(VENDOR_PATH . 'Bootstrap/4.1.3/js/bootstrap.min.js'); ?>" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url(VENDOR_PATH . 'DataTables/datatables.min.js'); ?>"></script>

    <!-- Load Script when needed only to make it FASTTTTTTTTTTTT -->
    <?php if ( isset( $js_to_load ) ) : ?>
        <?php foreach ( $js_to_load as $js_name ) : ?>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/<?=$js_name;?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">New LPP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url(); ?>pages/about">About</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Master Data
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo base_url(); ?>customers">Pelanggan</a>
                    <a class="dropdown-item" href="<?php echo base_url(); ?>materials">Bahan Baku</a>
                    <a class="dropdown-item" href="<?php echo base_url(); ?>process">Proses</a>
                    <a class="dropdown-item" href="<?php echo base_url(); ?>parts">Parts</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Transaksi
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo base_url(); ?>spks">SPK</a>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>spks">Produksi</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

<div class="container" style="max-width: 1440px;">
