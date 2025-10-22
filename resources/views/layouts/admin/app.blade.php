<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <style>
    /* Reset & cơ bản */
    * {
      box-sizing: border-box;
      margin: 0; padding: 0;
      font-family: Arial, sans-serif;
    }

    body, html {
      height: 100%;
    }

    .admin-container {
      display: flex;
      min-height: 100vh;
      background: #f4f6f8;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      color: #ecf0f1;
      padding: 20px 10px;
      display: flex;
      flex-direction: column;
    }

    .sidebar h2 {
      margin-bottom: 30px;
      font-size: 24px;
      text-align: center;
    }

    .sidebar a {
      color: #bdc3c7;
      text-decoration: none;
      padding: 12px 20px;
      border-radius: 5px;
      margin-bottom: 8px;
      transition: background-color 0.3s, color 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #34495e;
      color: #fff;
    }

    /* Main content */
    .admin-main {
      flex: 1;
      padding: 30px;
      background: #fff;
      overflow-y: auto;
    }

    /* Responsive: thu gọn sidebar */
    @media (max-width: 768px) {
      .admin-container {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        flex-direction: row;
        overflow-x: auto;
      }
      .sidebar a {
        flex: 1 0 auto;
        margin-right: 8px;
        margin-bottom: 0;
        text-align: center;
        padding: 10px 5px;
      }
    }
  </style>
</head>
<body>
  <div class="admin-container">
    @include('layouts.admin.sidebar')

    <main class="admin-main">
      @yield('content')
    </main>
  </div>
</body>
</html>
