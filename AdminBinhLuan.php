<?php 
class BinhLuan {
    private $pdo;

    public function __construct()
    {
        $this->pdo = connectDB(); // Giả sử hàm connectDB() đã được định nghĩa bên ngoài
    }

    public function getAll() {
        try {
            $sql = "
                SELECT 
                    binh_luans.*,
                    san_phams.ten_san_pham,
                    nguoi_dungs.ten_nguoi_dung AS nguoi_binh_luan
                FROM binh_luans
                JOIN san_phams ON binh_luans.san_pham_id = san_phams.id
                JOIN nguoi_dungs ON binh_luans.tai_khoan_id = nguoi_dungs.id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }
    

    // Cập nhật trạng thái bình luận (Hiện/Ẩn)
    public function insertBinhLuan($sanPhamId, $taiKhoanId, $noiDung)
    {
        try {
            $sql = "
                INSERT INTO binh_luans (san_pham_id, tai_khoan_id, noi_dung, ngay_dang, trang_thai)
                VALUES (:san_pham_id, :tai_khoan_id, :noi_dung, NOW(), 1)
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':san_pham_id', $sanPhamId, PDO::PARAM_INT);
            $stmt->bindParam(':tai_khoan_id', $taiKhoanId, PDO::PARAM_INT);
            $stmt->bindParam(':noi_dung', $noiDung, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Lỗi khi thêm bình luận: " . $e->getMessage();
            return false;
        }
    }
    
}
?>
