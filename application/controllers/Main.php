<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
    }

    function _remap() {
        
        if (!$this->session->userdata('user_id')) {
            redirect('/login');
        }
        $segment_1 = $this->uri->segment(1);
        $segment_2 = $this->uri->segment(2);
        $this->data['gender'] = $this->gender;
        if($segment_2 == '' && !strpos($segment_1,'.html')){ 
            $this->data['title'] = 'HOME';        
            $this->data['content'] = 'main/new_order';
            $this->load->view('layout_frontend_home', $this->data);
        } else if ($segment_2 == 'add_product_order') {
            $this->add_product_order();
        } else if ($segment_2 == 'new_order') {
            $this->data['content'] = 'main/new_order';
            if ($this->input->post('order_id')) {
                $this->data['orderData'] = $this->order_api(array("id"=>$this->session->userdata('order_id')));
                $html = '';
                if ($this->data['orderData'][0]['order_detail'] != '') {
                    $items = json_decode($this->data['orderData'][0]['order_detail'],true);
                    foreach ($items as $index => $value) {
                        $html .= $this->add_product_order($value,true);
                    }
                    $this->data['itemsData'] = $html;
                }
            }
            
            $this->load->view('layout_frontend_home', $this->data);
        } else if ($segment_2 == 'save_order'){
            $saveData = $this->input->post();
            if (isset($saveData['item_id'])) {
                $itemId = $saveData['item_id'];
                unset($saveData['item_id']);
            }
            
            if (isset($saveData['price'])) {
                $prdcPrice = $saveData['price'];
                unset($saveData['price']);
            }
            
            if (isset($saveData['amount'])) {
                $amount = $saveData['amount'];
                unset($saveData['amount']);
            }
            
            if (isset($saveData['total'])) {
                $totalPrice = $saveData['total'];
                unset($saveData['total']);
            }
            
            if (isset($itemId)) {
                $saveData['order_detail'] = array();
                for($i=0;$i<sizeof($itemId);$i++) {
                    $dummy = array();
                    $dummy['item_id'] = $itemId[$i];
                    $dummy['price'] = $prdcPrice[$i];
                    $dummy['amount'] = $amount[$i];
                    $dummy['total'] = $totalPrice[$i];
                    $saveData['order_detail'][] = $dummy;
                }
                
                if (sizeof($saveData['order_detail']) > 0) {
                    $saveData['order_detail'] = json_encode($saveData['order_detail']);
                }
            }
            
            $saveData['created_by'] = $this->session->userdata('user_id');
            $saveData['order_status'] = 'new';
            unset($saveData['ctgr_name']);
            if ($saveData['id'] != '' && $saveData['id'] > 0) {
                $result = $this->update_order($saveData);
            } else {
                unset($saveData['id']);
                $result = $this->save_order($saveData);
            }
            if ($result) {
                redirect('main/new_order');
            }
        } else if ($segment_2 == 'order') {
            $where['order_status'] = 'new';
            $where['created_by'] = $this->session->userdata('user_id');
            $dataOrder = $this->order_api($where);
            $this->data['orderData'] = $dataOrder;
            $this->data['content'] = 'main/order';
            $this->load->view('layout_frontend_home', $this->data);
        } else if ($segment_2 == 'changepass') {
            $this->changepass_api($this->session->userdata('user_email'));
            $this->session->set_flashdata('message_checkout', 'Silahkan cek email anda untuk mengganti password.');
            redirect('main/appointment');
        }
    }

    function save_order($data) {
        if (!$this->session->userdata('token')) {
            redirect('/');
        }
        $url = "http://localhost/primayaapi/orders/create";
        $ch = curl_init($url);
        $data_string = '';
        if (sizeof($data) > 0) {
            $data_string = http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$this->session->userdata('token').'')
        );

        if (curl_errno($ch)) {
            // moving to display page to display curl errors
            echo curl_errno($ch);
            echo curl_error($ch);
            return false;
        } else {
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response,true);
        }
    }
    
    function update_order($data) {
        if (!$this->session->userdata('token')) {
            redirect('/');
        }
        $url = "http://localhost/primayaapi/orders/update/".$data['id']."";
        $ch = curl_init($url);
        $data_string = '';
        if (sizeof($data) > 0) {
            $data_string = http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$this->session->userdata('token').'')
        );

        if (curl_errno($ch)) {
            // moving to display page to display curl errors
            echo curl_errno($ch);
            echo curl_error($ch);
            return false;
        } else {
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response,true);
        }
    }
    
    function category_api() {
        if (!$this->session->userdata('token')) {
            redirect('/');
        }
        $url = "http://localhost/primayaapi/category";
        $ch = curl_init($url);

        $data_string = '';                                                                                   
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$this->session->userdata('token').'')
        );

        if (curl_errno($ch)) {
            echo curl_errno($ch);
            echo curl_error($ch);
            return false;
        } else {
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response,true);
            if(isset($result['error'])) {
                redirect('/login/logout');
            }
            return json_decode($response,true);
        }
    }
    function order_api($data) {
        if (!$this->session->userdata('token')) {
            redirect('/');
        }
        $url = "http://localhost/primayaapi/orders/order";
        $ch = curl_init($url);

        $data_string = '';
        if (sizeof($data) >0) {
            $data_string = http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$this->session->userdata('token').'')
        );

        if (curl_errno($ch)) {
            echo curl_errno($ch);
            echo curl_error($ch);
            return false;
        } else {
            $response = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($response,true);
            if(isset($result['error'])) {
                redirect('/login/logout');
            }
            return json_decode($response,true);
        }
    }
    
    function product_api() {
        if (!$this->session->userdata('token')) {
            redirect('/');
        }
        $url = "http://localhost/primayaapi/products/getall";
        $ch = curl_init($url);

        $data = array('prdc_status'=>'ready');
        $data_string = http_build_query($data);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$this->session->userdata('token').'')
        );

        if (curl_errno($ch)) {
            // moving to display page to display curl errors
            echo curl_errno($ch);
            echo curl_error($ch);
            return false;
        } else {
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response,true);
        }
    }
    
    function delete_order_api($regNmbr='') {
        if (!$this->session->userdata('token')) {
            redirect('/');
        }
        
        $url = "http://localhost/primayaapi/orders/delete_order";
        $ch = curl_init($url);
        $data_string = '';
        if ($regNmbr != '') {
            $data = array('order_reg_nmbr'=>$regNmbr);
            $data_string = http_build_query($data);
        }
                                                                           
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer '.$this->session->userdata('token').'')
        );

        if (curl_errno($ch)) {
            echo curl_errno($ch);
            echo curl_error($ch);
            return false;
        } else {
            $response = curl_exec($ch);
            curl_close($ch);
            return json_decode($response,true);
        }
    }
    
    function add_product_order($tableData = array(), $html = false) {
        $product = $this->product_api();
        $temp = '<tr>'
                .'<td style="width:50%"><div class="col-md-12">'
                . '<select id="item_id[]" name="item_id[]" class="form-control" '
                . 'onchange="javascript:get_price(this)">'
                . '<option value="">-- CHOOSE ONE --</option>';
                $selected = '';
                foreach($product as $index => $value) {
                    if (sizeof($tableData) > 0) {
                        if ($tableData['item_id'] == $value['id']) {
                            $selected = "selected='selected'";
                        } else {
                            $selected = '';
                        }
                    }
                    $temp .= '<option value="'.$value['id'].'" '.$selected.' price="'.$value['prdc_price'].'">'.$value['prdc_name'].'</option>';
                }
        $temp .='</select></div></td>'
                .'<td><input type="text" id="price[]" name="price[]" readonly '
                . 'class="form-control price_info" value="'.(isset($tableData['price'])? $tableData['price'] :'').'"/></td>'
                .'<td><input id="amount[]" name="amount[]" class="form-control amount" type="text" '
                . 'value="'.(isset($tableData['amount']) ? $tableData['amount']:'0').'" '
                . 'onkeyup="javascript:sum_total_row(this)"/></td>'
                .'<td><input id="total[]" name="total[]" class="form-control total_row" '
                . 'required="required" type="text" value="'.(isset($tableData['total']) ? $tableData['total']:'0').'" /></td>'
                . '<td><img src="' . base_url() . 'assets/polo/images/delete.gif" onclick="javascript:delproduct(this);"/></td>'
                . '</tr>';
        if ($html) {
            return $temp;
        } else {
            $data['htmldata'] = $temp;
            echo json_encode($data);
        }
    }
}
