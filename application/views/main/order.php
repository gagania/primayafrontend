<!--<link rel="stylesheet" href="<?=base_url()?>assets/polo/js/plugins/components/datatables/dataTables.bootstrap.css">-->

<div class="col-lg-12">
    <table id="order_list" class="table table-hover table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Table</th>
                <th scope="col">User Name</th>
                <th scope="col">Order Number</th>
                <th scope="col">Aciton</th>
            </tr>
        </thead>
        <tbody>
            <?php if(sizeof($orderData) > 0) {
                $i=1;
                foreach($orderData as $index => $value){?>
                    <tr>
                        <td scope="row"><?=$i?></td>
                        <td><?=$value['order_table']?></td>
                        <td><?=$value['order_user_name']?></td>
                        <td><?=$value['order_nmbr']?></td>
                        <td>
                            <form method="post" action="<?=base_url().$this->router->fetch_class()?>/new_order">
                                <input id="order_id" name="order_id" value="<?=$value['id']?>" type="hidden"/>
                                <button type="submit" class="btn btn-primary">Detail</button>
                            </form>
                        </td>
                    </tr>
            <?php $i++;
                }
            }?>
        </tbody>
    </table>
</div>
<!--<script src="<?=base_url()?>assets/polo/js/plugins/components/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/polo/js/plugins/components/datatables/dataTables.bootstrap.min.js"></script>-->
<script type="text/javascript">//
//    $(document).ready(function() {
//        $('#order_list').DataTable({
//            'paging'      : true,
//            'lengthChange': true,
//            'searching'   : true,
//            'ordering'    : true,
//            'info'        : true,
//            'autoWidth'   : true,
//            "order": [[ 0, "desc" ]]
//          });
//    });              
//</script>