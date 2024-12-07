<div class="row">
        <h3>
            <div class="text-center text-success">DANH SÁCH NHÀ XUẤT BẢN</div>
        </h3>
        <div class="col-12 d-flex justify-content-center">
            <button class="btn"><a href="index.php?insert_brand" class="btn nav-link text-light bg-info my-1">Thêm
                    nhà xuất bản</a></button>
        </div>
    </div>

    <table class=" table table-bordered mt-5 text-center">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên nhà xuất bản</th>
                <th>Chỉnh sửa</th>
                <th>Xóa</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $get_nxb = "SELECT * FROM `nhaxuatban`";
            $stmt = $con->prepare($get_nxb);
            $stmt->execute();
            $row_nxb_all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stt = 0;
            foreach ($row_nxb_all as $row) {
                $stt++;
                $nxb_id = $row['nxb_id'];
                $nxb_name = $row['nxb_title'];
                ?>
                <tr>
                    <td><?php echo $stt; ?></td>
                    <td><?php echo $nxb_name; ?></td>
                    <td>
                        <a href="index.php?edit_brands=<?php echo $nxb_id ?>"><i
                                class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                    <td>
                        <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $nxb_id; ?>)"><i
                                class="fa-solid fa-trash text-danger"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <script>
        function confirmDelete(nxb_id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa nhà xuất bản này?',
                text: "Bạn sẽ không thể khôi phục lại sau khi xóa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?delete_brand=' + nxb_id;
                }
            });
        }
    </script>