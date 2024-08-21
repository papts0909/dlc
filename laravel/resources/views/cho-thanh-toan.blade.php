<!DOCTYPE html>
<html>
<head>
    <title>Chờ thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <h2>Chờ thanh toán</h2>
        <p id="notification" class="alert alert-info">Đang chờ thanh toán...</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.socket.io/4.4.1/socket.io.min.js"></script>
    <script>
        // Laravel Echo 
        Echo.channel('thanh-toan-channel')
            .listen('ThanhToanThanhCong', (e) => {
                $('#notification').text('Thanh toán thành công!');
                $('#notification').removeClass('alert-info').addClass('alert-success');
            });
    </script>
</body>
</html>