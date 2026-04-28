<?php
// admin/header.php
require_once __DIR__ . '/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Rocks GenZ Granites</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--bg-dark);
            color: var(--text-light);
            padding: 2rem 1rem;
        }

        .sidebar a {
            color: var(--text-light);
            display: block;
            padding: 0.8rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 4px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--primary-color);
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            background-color: var(--bg-secondary);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2 style="color: var(--primary-color); text-align: center; margin-bottom: 2rem;">Admin Panel</h2>
            <nav>
                <a href="/admin/index.php">Dashboard</a>
                <a href="/admin/categories.php">Categories</a>
                <a href="/admin/products.php">Products</a>
                <a href="/admin/blog.php">Blog Posts</a>
                <a href="/admin/gallery.php">Gallery</a>
                <a href="/admin/menus.php">Menu Builder</a>
                <a href="/admin/settings.php">Settings</a>
                <a href="/admin/inquiries.php">Inquiries</a>
                <a href="/admin/logout.php" style="color: #ff6b6b; margin-top: 2rem;">Logout</a>
            </nav>
        </aside>
        <main class="main-content">