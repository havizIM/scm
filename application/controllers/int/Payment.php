<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Payment extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    } 

    function __construct()
    {
        parent::__construct();
        $this->__resTraitConstruct();

        $this->where    = array('token' => $this->input->get_request_header('SCM-INT-KEY', TRUE));
        $this->user     = $this->AuthModel->cekAuthInt($this->where);

        $this->load->model('InvoiceModel');
        $this->load->model('PaymentModel');
    }

    public function index_get()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            
            $where = array(
                'a.no_payment'      => $this->get('no_payment'),
            );

            $show   = $this->PaymentModel->show($where)->result();
            $payment   = array();

            foreach($show as $key){
                $json = array();

                $json['no_payment']       = $key->no_payment;
                $json['supplier']       = array(
                    'id_supplier'        => $key->id_supplier,
                    'nama_supplier'      => $key->nama_supplier,
                    'alamat'             => $key->alamat,
                    'telepon'            => $key->telepon,
                    'fax'                => $key->fax,
                    'email'              => $key->email,
                    'npwp'               => $key->npwp,
                    'status_supplier'    => $key->status_supplier
                );
                $json['account']       = array(
                    'id_account'         => $key->id_account,
                    'id_supplier'        => $key->id_supplier,
                    'nama_supplier'      => $key->nama_supplier,
                    'nama_bank'          => $key->nama_bank,
                    'cabang'             => $key->cabang,
                    'pemilik_account'    => $key->pemilik_account,
                    'no_rekening'        => $key->no_rekening
                );
                $json['tgl_payment']    = $key->tgl_payment;
                $json['status_payment'] = $key->status_payment;
                $json['total_bayar']    = $key->total_bayar;
                
                $json['detail']         = array();

                $where_2   = array('a.no_payment' => $key->no_payment);
                $detail   = $this->PaymentModel->detail($where_2);

                foreach($detail->result() as $key1){
                    $json_ba = array();
                    $sub_total = 0;
                    $ppn_total = 0;

                    $json_ba['no_invoice']      = $key1->no_invoice;
                    $json_ba['no_order']        = $key1->no_order;
                    $json_ba['nama_supplier']   = $key1->nama_supplier;
                    $json_ba['jml_bayar']       = $key1->jml_bayar;

                    $where_3   = array('no_invoice' => $key1->no_invoice);
                    $hutang   = $this->InvoiceModel->detail($where_3);

                    foreach($hutang->result() as $key1){
                        $sub_total += $key1->total_harga;
                        $ppn_total += $key1->ppn;
                    }

                    $json_ba['hutang']         = $sub_total + $ppn_total;

                    $json['detail'][] = $json_ba;
                }

                $payment[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $payment
            );

            $this->response($response, 200);
        }
    }

    public function add_post()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            $this->form_validation->set_data($this->post());
            
            $this->form_validation->set_rules('id_account', 'Account', 'required|trim');
            $this->form_validation->set_rules('tgl_payment', 'Tanggal Payment', 'required|trim');
            $this->form_validation->set_rules('total_bayar', 'Total Bayar', 'required|trim');

            $this->form_validation->set_rules('no_invoice[]', 'No invoice', 'required|trim');
            $this->form_validation->set_rules('jml_bayar[]', 'Jumlah Bayar', 'required|trim');

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {

                $post           = $this->post();
                $no_payment     = $this->KodeModel->buatKode('payment', 'PVC-', 'no_payment', 7);
                $grand_total    = 0;

                $detail  = array();

                foreach($post['no_invoice'] as $key => $val){
                    $detail[] = array(
                        'no_payment'     => $no_payment,
                        'no_invoice'     => $post['no_invoice'][$key],
                        'jml_bayar'      => $post['jml_bayar'][$key]
                    );
                }

                $data           = array(
                    'no_payment'      => $no_payment,
                    'id_account'      => $post['id_account'],
                    'tgl_payment'     => $post['tgl_payment'],
                    'total_bayar'     => $post['total_bayar'],
                    'status_payment'  => 'Open'
                );

                $add = $this->PaymentModel->add($data, $detail);

                if(!$add){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed add payment'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success add payment'
                    ), 200);
                }
            }
        } 
    }

    public function laporan_post()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            $this->form_validation->set_data($this->post());
            
           $this->form_validation->set_rules('bulan', 'bulan', 'required|trim');
           $this->form_validation->set_rules('tahun', 'tahun', 'required|trim');

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {

                 $where = array(
                    'MONTH(a.tgl_payment)'  => $this->post('bulan'),
                    'YEAR(a.tgl_payment)'   => $this->post('tahun'),
                    'a.status_payment'      => 'Close'
                );

                $show       = $this->PaymentModel->show($where)->result();
                $payment    = array();

                foreach($show as $key){
                    $json = array();

                    $json['no_payment']       = $key->no_payment;
                    $json['supplier']       = array(
                        'id_supplier'        => $key->id_supplier,
                        'nama_supplier'      => $key->nama_supplier,
                        'alamat'             => $key->alamat,
                        'telepon'            => $key->telepon,
                        'fax'                => $key->fax,
                        'email'              => $key->email,
                        'npwp'               => $key->npwp,
                        'status_supplier'    => $key->status_supplier
                    );
                    $json['account']       = array(
                        'id_account'         => $key->id_account,
                        'id_supplier'        => $key->id_supplier,
                        'nama_supplier'      => $key->nama_supplier,
                        'nama_bank'          => $key->nama_bank,
                        'cabang'             => $key->cabang,
                        'pemilik_account'    => $key->pemilik_account,
                        'no_rekening'        => $key->no_rekening
                    );
                    $json['tgl_payment']    = $key->tgl_payment;
                    $json['status_payment'] = $key->status_payment;
                    $json['total_bayar']    = $key->total_bayar;
                    
                    $json['detail']         = array();

                    $where_2   = array('a.no_payment' => $key->no_payment);
                    $detail   = $this->PaymentModel->detail($where_2);

                    foreach($detail->result() as $key1){
                        $json_ba = array();

                        $json_ba['no_invoice']      = $key1->no_invoice;
                        $json_ba['no_order']        = $key1->no_order;
                        $json_ba['nama_supplier']   = $key1->nama_supplier;
                        $json_ba['jml_bayar']       = $key1->jml_bayar;

                        $json['detail'][] = $json_ba;
                    }

                    $payment[] = $json;
                }

                $response = array(
                    'status'    => true,
                    'message'   => 'Success fetch report',
                    'data'      => $payment
                );

                $this->response($response, 200);
            }
        }
    }

    public function edit_put()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $user = $this->user->row();
            $this->form_validation->set_data($this->put());
            
            $this->form_validation->set_rules('no_payment', 'Payment', 'required|trim');
            $this->form_validation->set_rules('id_account', 'Account', 'required|trim');
            $this->form_validation->set_rules('tgl_payment', 'Tanggal Payment', 'required|trim');
            $this->form_validation->set_rules('total_bayar', 'Total Bayar', 'required|trim');

            $this->form_validation->set_rules('no_invoice[]', 'No invoice', 'required|trim');
            $this->form_validation->set_rules('jml_bayar[]', 'Jumlah Bayar', 'required|trim');

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {

                $put           = $this->put();

                $detail  = array();

                foreach($put['no_invoice'] as $key => $val){
                    $detail[] = array(
                        'no_payment'     => $put['no_payment'],
                        'no_invoice'     => $put['no_invoice'][$key],
                        'jml_bayar'      => $put['jml_bayar'][$key]
                    );
                }

                $data           = array(
                    'id_account'      => $put['id_account'],
                    'tgl_payment'     => $put['tgl_payment'],
                    'total_bayar'     => $put['total_bayar']
                );

                $where          = array(
                    'no_payment'      => $put['no_payment'],
                );

                $edit = $this->PaymentModel->edit($where, $data, $detail);

                if(!$edit){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed edit payment'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success edit payment'
                    ), 200);
                }
            }
        }
    }

    public function delete_delete()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $config = array(
                array(
                    'field' => 'no_payment',
                    'label' => 'Payment',
                    'rules' => 'required|trim'
                )
            );

            $this->form_validation->set_data($this->delete());
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {
                $where  = array(
                    'no_payment'   => $this->delete('no_payment') 
                );

                $delete = $this->PaymentModel->delete($where);

                if(!$delete){
                    $this->response(array(
                        'status'    => false,
                        'error'     => 'Failed delete payment'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success delete payment'
                    ), 200);
                }
            }
        } 
    }

}
