<?php
include "./DAO/Database.php";
class User{
    public function __construct($ten, $gioiTinh, $ngaySinh, $queQuan, $noiOHienTai, $soThich, $gioiThieu, $anhDaiDien, $anhBia)
    {
        $this->ten = $ten;
        $this->gioiTinh = $gioiTinh;
        $this->ngaySinh = $ngaySinh;
        $this->$queQuan = $queQuan;
        $this->$noiOHienTai = $noiOHienTai;
        $this->soThich = $soThich;
        $this->gioiThieu = $gioiThieu;
        if($anhDaiDien==null){
            $this->anhDaiDien = "./Data/Photo/avatar/avatar-mac-dinh.jpg";
        }
        else
        $this->anhDaiDien = $anhDaiDien;
        if($anhBia==null){
            $this->anhBia = "./Data/Photo/cover_photo/no-cover-photo.jpg";
        }
        else
        $this->anhBia = $anhBia;
    }
    private $idAcc;
    private $ten;
    private $gioiTinh;
    private $ngaySinh;
    private $queQuan;
    private $noiOHienTai;
    private $soThich;
    private $gioiThieu;
    private $anhDaiDien;
    private $anhBia;
    public function getTen(){
        return $this->ten;
    }
    public function getGioiTinh(){
        return $this->gioiTinh;
    }
    public function getNgaySinh(){
        return $this->ngaySinh;
    }
    public function getQueQuan(){
        return $this->queQuan;
    }
    public function getNoiOHienTai(){
        return $this->noiOHienTai;
    }
    public function getSoThich(){
        return $this->soThich;
    }
    public function getGioiThieu(){
        return $this->gioiThieu;
    }
    public function getAnhDaiDien(){
        return $this->anhDaiDien;
    }
    public function getAnhBia(){
        return $this->anhBia;
    }
    public function setTen($ten){
        $this->ten = $ten;
    }
    public function setGioiTinh($gioiTinh){
        $this->gioiTinh = $gioiTinh;
    }
    public function setNgaySinh($ngaySinh){
        $this->ngaySinh = $ngaySinh;
    }
    public function setQueQuan($queQuan){
        $this->queQuan = $queQuan;
    }
    public function setNoiOHienTai($noiOHienTai){
        $this->noiOHienTai = $noiOHienTai;
    }
    public function setSoThich($soThich){
        $this->soThich = $soThich;
    }
    public function setGioiThieu($gioiThieu){
        $this->gioiThieu = $gioiThieu;
    }
    public function setAnhDaiDien($anhDaiDien){
        $this->gioiThieu = $anhDaiDien;
    }
    public function setAnhBia($anhBia){
        $this->gioiThieu = $anhBia;
    }
}
class UserModel{
    public function getUserById($id){
        $conn = new Conn();
        $conn = $conn->connect();
        $stmt = $conn->stmt_init();
        $sql = "select * from user where id = ?";
        $stmt->prepare($sql);
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result){
            $row = $result->fetch_assoc();
            $user = new User($row['ten'], $row['gioi_tinh'], $row['ngay_sinh'], $row['que_quan'], $row['noi_o_hien_tai'], $row['so_thich'], $row['gioi_thieu'], $row['anh_dai_dien'], $row['anh_bia']);
            return $user;            
        }
        else{
            return null;
        }
    }
}