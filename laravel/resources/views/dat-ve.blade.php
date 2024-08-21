<!DOCTYPE html>
<html>
<head>
    <title>Đặt vé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <h2>Đặt vé</h2>
        <form id="dat-ve-form">
            <div class="mb-3">
                <label for="ma_ghe" class="form-label">Mã ghế</label>
                <input type="text" class="form-control" id="ma_ghe" name="ma_ghe" required>
            </div>
            <div class="mb-3">
                <label for="ma_chuyen" class="form-label">Mã chuyến</label>
                <input type="text" class="form-control" id="ma_chuyen" name="ma_chuyen" required>
            </div>
            <div class="mb-3">
                <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required>
            </div>
            <div class="mb-3">
                <label for="gia_ve" class="form-label">Giá vé</label>
                <input type="number" class="form-control" id="gia_ve" name="gia_ve" required>
            </div>
            <div class="mb-3">
                <label for="ten_hanh_khach" class="form-label">Tên hành khách</label>
                <input type="text" class="form-control" id="ten_hanh_khach" name="ten_hanh_khach" required>
            </div>
            <div class="mb-3">
                <label for="ma_the" class="form-label">Mã thẻ</label>
                <input type="text" class="form-control" id="ma_the" name="ma_the" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required>
            </div>
            <button type="submit" class="btn btn-primary">Đặt vé</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dat-ve-form').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: 'http://localhost:8000/api/dat-ve'
                    , type: 'POST'
                    , data: $(this).serialize()
                    , success: function(response) {
                        // Chuyển hướng đến trang chờ thanh toán
                        window.location.href = '/cho-thanh-toan';
                    }
                    , error: function(xhr) {
                        alert('Đặt vé không thành công. Vui lòng thử lại.');
                    }
                });
            });
        });

    </script>
</body>
</html>
