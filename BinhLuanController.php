<?php
class BinhLuanController {
    public $modelBinhLuan;

    public function __construct() {
        $this->modelBinhLuan = new BinhLuan();
    }

    // Hiển thị danh sách bình luận
    public function ListBinhLuan() {
        $listBinhLuan = $this->modelBinhLuan->getAll();
        
        // Debug: kiểm tra dữ liệu trả về

        require_once 'views/sanpham/list_binhluan.php'; // Trỏ đến file view danh sách bình luận
    }
    

    // Chuyển trạng thái bình luận giữa Hiện và Ẩn
    public function addBinhLuan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sanPhamId = $_POST['san_pham_id']; // ID sản phẩm được bình luận
            $taiKhoanId = $_POST['tai_khoan_id']; // ID tài khoản người dùng
            $noiDung = $_POST['noi_dung']; // Nội dung bình luận
    
            // Kiểm tra dữ liệu không rỗng
            if (!empty($sanPhamId) && !empty($taiKhoanId) && !empty($noiDung)) {
                $result = $this->modelBinhLuan->insertBinhLuan($sanPhamId, $taiKhoanId, $noiDung);
                if ($result) {
                    // Chuyển hướng về trang hiện tại hoặc hiển thị thông báo thành công
                    header("Location:  index.php?act=chi-tiet-san-pham&id=" . $sanPhamId);
                    exit;
                } else {
                    echo "Lỗi khi thêm bình luận.";
                }
            } else {
                echo "Vui lòng nhập đầy đủ thông tin.";
            }
        }
    }
    


}
?>
