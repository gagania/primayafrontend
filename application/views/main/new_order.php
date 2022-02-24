<section id="peta">
    <div class="container">
        <div class="col-md-12 center">
            <div class="row">
                <div class="col-lg-12 center no-padding">
                    <form id="registration_form" method="post" action="<?= base_url() . $this->router->fetch_class() ?>/save_order" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label" style="text-align: left" >Tanggal</label>
                                <div class="col-md-3">
                                    <input id="order_date" name="order_date" 
                                           required class="form-control" type="text" 
                                           readonly value="<?=date('d/m/Y H:i:s')?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label" style="text-align: left" >Table Number</label>
                                <div class="col-md-2">
                                    <input type="text" id="order_table" name="order_table" 
                                           value="<?=isset($orderData)? $orderData[0]['order_table']:''?>" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label" style="text-align: left" >User Nama</label>
                                <div class="col-md-6">
                                    <input type="text" id="order_user_name" name="order_user_name" 
                                           value="<?=isset($orderData)? $orderData[0]['order_user_name']:''?>" class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label" style="text-align: left" >Items</label>
                                <div class="col-md-8">
                                   <div class=""><?php include 'add_order_row.php'; ?> </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label" style="text-align: left" >Harga</label>
                                <div class="col-md-6">
                                    <input type="text" id="order_cost" name="order_cost" 
                                           value="<?=isset($orderData)? $orderData[0]['order_cost']:'0'?>" 
                                           class="form-control" readonly/>
                                    <!--<input type="hidden" id="order_cost" name="order_cost" value="<?=isset($prdc_price) ? $prdc_price:''?>"/>-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label" style="text-align: left" >Ppn (10%)</label>
                                <div class="col-md-6">
                                    <input type="text" id="order_ppn" name="order_ppn" 
                                           value="<?=isset($orderData)? $orderData[0]['order_ppn']:'0'?>" 
                                           class="form-control" readonly/>
                                    <!--<input type="hidden" id="order_ppn" name="order_ppn" value="<?=isset($prdc_price) ? (0.1*$prdc_price):''?>"/>-->
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label" style="text-align: left" >Total</label>
                                <div class="col-md-6">
                                    <input type="text" id="order_total_cost" name="order_total_cost" 
                                           value="<?=isset($orderData)? $orderData[0]['order_total_cost']:'0'?>" 
                                           class="form-control" readonly/>
                                    <!--<input type="hidden" id="order_total_cost" name="order_total_cost" value="<?=isset($prdc_price) ? $prdc_price + (0.1*$prdc_price):''?>"/>-->
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 center">
                            <input type="hidden" id="id" name="id" value="<?=isset($orderData)? $orderData[0]['id']:'0'?>"/>
                            <!--<button id="pay-button" type="button" onclick="" class="btn m-t-30 mt-3">Checkout</button>-->
                            <button type="submit" class="btn m-t-30 mt-3">Create Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('.datepicker').datepicker({
            dateFormat: 'dd/mm/yyyy'
//            startDate: '-3d'
        });
    });
</script>