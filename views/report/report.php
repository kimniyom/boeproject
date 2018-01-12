<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>ชื่อ - สกุล</th>
            <th>ที่อยู่</th>
            <th>ผู้รายงาน</th>
            <th>วันที่</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($report as $rs): $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $rs['name'] ?></td>
                <td><?php echo $rs['address'] ?></td>
                <td><?php echo $rs['hospcode'] . " | " . $rs['author'] ?></td>
                <td><?php echo $rs['createdate'] ?></td>
                <td style=" text-align: center;">
                    <?php
                    if (Yii::$app->user->identity->id == $rs['userid']) {
                        ?>
                        <button type="button" class="btn btn-danger btn-xs" onclick="deletereport('<?php echo $rs['id'] ?>')"><i class="fa fa-trash-o"></i></button>
                        <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    function deletereport(id) {
        var url = "<?php echo \yii\helpers\Url::to(['report/delete']) ?>";
        var data = {id: id};
        var r = confirm("Are you sure...?");
        if (r == true) {
            $.post(url, data, function (datas) {
                Getreport();
            });
        }
    }
</script>
