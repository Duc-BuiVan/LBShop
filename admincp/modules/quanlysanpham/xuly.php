<?php
    include "../../config/connect.php";
    $tensanpham=$_POST['tensanpham'];
    $masanpham=$_POST['masanpham'];
    $giasanpham=$_POST['giasanpham'];
    $soluong=$_POST['soluong'];
    $file=$_FILES['hinhanh'];
    $hinhanh=$file['name'];
    $hinhanh_tmp=$_FILES['hinhanh']['tmp_name'];
    $hinhanhgio=time().'_'.$hinhanh;
    $tomtat = $_POST['tomtat'];
    $noidung=$_POST['noidung'];
    $hienthi=$_POST['hienthi'];
    $loaisanpham=$_POST['loaisanpham'];
    $nhacungcap=$_POST['nhacungcap'];

    if(isset($_POST['them'])){
        if(isset($_FILES['hinhanh'])){
            if($file['type']== 'image/jpeg'||$file['type']== 'imgae/jpg'||$file['type']== 'image/png'){
                move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
                $sql_themsp="INSERT INTO tbl_sanpham(tensanpham,masanpham,giasanpham,soluong,hinhanh,tomtat,noidung,trangthai,id_loaisanpham,id_nhacungcap) 
                VALUE ('".$tensanpham."','".$masanpham."','".$giasanpham."','".$soluong."','".$hinhanh."','".$tomtat."','".$noidung."',".$hienthi.",'".$loaisanpham."','".$nhacungcap."')";
                mysqli_query($connect,$sql_themsp);
                header('Location:../../index.php?action=quanlysanpham&query=them');
            }else{
                $hinhanh='';
                header('Location:../../index.php?action=quanlysanpham&query=them');
            }
        }
    }

    elseif(isset($_POST['sua'])){
        if($hinhanh!=''){
            move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
            $sql_sua="UPDATE tbl_sanpham SET tensanpham='".$tensanpham."',masanpham='".$masanpham."', giasanpham='".$giasanpham."',soluong='".$soluong."',hinhanh='".$hinhanh."', tomtat='".$tomtat."',noidung='".$noidung."',trangthai='".$hienthi."',id_loaisanpham='".$loaisanpham."', id_nhacungcap='".$nhacungcap."' WHERE id_sanpham='$_GET[id_sanpham]'";
            $sql="SELECT * FROM tbl_sanpham WHERE id_sanpham='$_GET[id_sanpham]' LIMIT 1";
            $query=mysqli_query($connect,$sql);
            while($row=mysqli_fetch_array($query)){
                unlink('uploads/'.$row['hinhanh']);
            }
        }else{
            $sql_sua="UPDATE tbl_sanpham SET tensanpham='".$tensanpham."',masanpham='".$masanpham."', giasanpham='".$giasanpham."',soluong='".$soluong."',tomtat='".$tomtat."', noidung='".$noidung."',trangthai='".$hienthi."',id_loaisanpham='".$loaisanpham."', id_nhacungcap='".$nhacungcap."' WHERE id_sanpham='$_GET[id_sanpham]'";
        }  
        mysqli_query($connect,$sql_sua);
        header('Location:../../index.php?action=quanlysanpham&query=them');
    }

    else{
        $id=$_GET['id_sanpham'];
        $sql="SELECT * FROM tbl_sanpham WHERE id_sanpham = '$id' LIMIT 1";
        $query=mysqli_query($connect,$sql);
        while($row=mysqli_fetch_array($query)){
            unlink('uploads/'.$row['hinhanh']);
        }
        $sql_xoa="DELETE FROM tbl_sanpham WHERE id_sanpham ='".$id."';";
        mysqli_query($connect,$sql_xoa);
        header('Location:../../index.php?action=quanlysanpham&query=them');
    }
?>