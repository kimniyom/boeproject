<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . $model['note'] . " " . $title . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table><thead><tr>
            <th>#</th>
            <th>ชื่อ - สกุล</th>
            <th>ที่อยู่</th>
            <th>ผู้บันทึก</th>
            <th>วันที่</th>
        </tr></thead><tbody>
        <?php
        $i = 0;
        foreach ($result as $rs):$i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $rs['name'] ?></td>
                <td><?php echo $rs['address'] ?></td>
                <td><?php echo $rs['author'] ?></td>
                <td><?php echo $rs['createdate'] ?></td>
            </tr>
            <?php
        endforeach;
        ?>
    </tbody></table>
