<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Invoice extends CI_Controller {

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
                'a.no_invoice'    => $this->get('no_invoice'),
                'd.id_supplier'   => $this->get('id_supplier')
            );

            $show   = $this->InvoiceModel->show($where)->result();
            $invoice   = array();

            foreach($show as $key){
                $json           = array();
                $sub_total      = 0;
                $ppn_total      = 0;

                $json['no_invoice']         = $key->no_invoice;
                $json['no_order']           = $key->no_order;
                $json['warehouse']      = array(
                    'id_warehouse'      => $key->id_warehouse,
                    'nama_warehouse'    => $key->nama_warehouse,
                    'alamat'            => $key->alamat_warehouse,
                    'telepon'           => $key->telepon_warehouse,
                    'fax'               => $key->fax_warehouse,
                    'email'             => $key->email_warehouse
                );
                $json['supplier']           = array(
                    'id_supplier'        => $key->id_supplier,
                    'nama_supplier'      => $key->nama_supplier,
                    'alamat'             => $key->alamat_supplier,
                    'telepon'            => $key->telepon_supplier,
                    'fax'                => $key->fax_supplier,
                    'email'              => $key->email_supplier,
                    'npwp'               => $key->npwp,
                    'status_supplier'    => $key->status_supplier
                );
                $json['tgl_invoice']        = $key->tgl_invoice;
                $json['tgl_tempo']          = $key->tgl_tempo;
                $json['status_invoice']     = $key->status_invoice;
                
                $json['detail']         = array();

                $where_2   = array('no_invoice' => $key->no_invoice);
                $detail   = $this->InvoiceModel->detail($where_2);

                foreach($detail->result() as $key1){
                    $json_ba = array();
                    $sub_total += $key1->total_harga;
                    $ppn_total += $key1->ppn;

                    $json_ba['deskripsi']   = $key1->deskripsi;
                    $json_ba['harga']       = $key1->harga;
                    $json_ba['qty']         = $key1->qty;
                    $json_ba['ppn']         = $key1->ppn;
                    $json_ba['total_harga'] = $key1->total_harga;

                    $json['detail'][] = $json_ba;
                }

                $json['grand_total']         = $sub_total + $ppn_total;

                $invoice[] = $json;
            }

            $response = array(
                'status'    => true,
                'message'   => 'Success fetch warehouses',
                'data'      => $invoice
            );

            $this->response($response, 200);
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
                    'MONTH(a.tgl_invoice)'  => $this->post('bulan'),
                    'YEAR(a.tgl_invoice)'   => $this->post('tahun'),
                    'a.status_invoice'      => 'Close'
                );

                $show   = $this->InvoiceModel->show($where)->result();
                $hutang   = array();

                foreach($show as $key){
                    $json           = array();
                    $sub_total      = 0;
                    $ppn_total      = 0;

                    $json['no_invoice']         = $key->no_invoice;
                    $json['no_order']           = $key->no_order;
                    $json['warehouse']      = array(
                        'id_warehouse'      => $key->id_warehouse,
                        'nama_warehouse'    => $key->nama_warehouse,
                        'alamat'            => $key->alamat_warehouse,
                        'telepon'           => $key->telepon_warehouse,
                        'fax'               => $key->fax_warehouse,
                        'email'             => $key->email_warehouse
                    );
                    $json['supplier']           = array(
                        'id_supplier'        => $key->id_supplier,
                        'nama_supplier'      => $key->nama_supplier,
                        'alamat'             => $key->alamat_supplier,
                        'telepon'            => $key->telepon_supplier,
                        'fax'                => $key->fax_supplier,
                        'email'              => $key->email_supplier,
                        'npwp'               => $key->npwp,
                        'status_supplier'    => $key->status_supplier
                    );
                    $json['tgl_invoice']        = date('Y-m-d', strtotime($key->tgl_invoice));
                    $json['tgl_tempo']          = $key->tgl_tempo;
                    $json['status_invoice']     = $key->status_invoice;
                    
                    $json['detail']         = array();
                    $json['hutang']         = array();

                    $where_2   = array('no_invoice' => $key->no_invoice);
                    $detail   = $this->InvoiceModel->detail($where_2);

                    foreach($detail->result() as $key1){
                        $json_ba = array();
                        $sub_total += $key1->total_harga;
                        $ppn_total += $key1->ppn;

                        $json_ba['deskripsi']   = $key1->deskripsi;
                        $json_ba['harga']       = $key1->harga;
                        $json_ba['qty']         = $key1->qty;
                        $json_ba['ppn']         = $key1->ppn;
                        $json_ba['total_harga'] = $key1->total_harga;

                        $json['detail'][] = $json_ba;
                    }

                    $json['grand_total']         = $sub_total + $ppn_total;

                    $where_3   = array('a.no_invoice' => $key->no_invoice, 'e.status_payment' => 'Close');
                    $payment   = $this->PaymentModel->detail($where_3);

                    foreach($payment->result() as $key2){
                        $json_py = array();

                        $json_py['no_payment']      = $key2->no_payment;
                        $json_py['tgl_payment']     = $key2->tgl_payment;
                        $json_py['status_payment']  = $key2->status_payment;
                        $json_py['jml_bayar']       = $key2->jml_bayar;

                        $json['payment'][] = $json_py;
                    }

                    $hutang[] = $json;
                }

                $response = array(
                    'status'    => true,
                    'message'   => 'Success fetch report',
                    'data'      => $hutang
                );

                $this->response($response, 200);
            }
        }
    }

    public function approve_put()
    {
        if($this->user->num_rows() == 0){
            $this->response(array('status' => false, 'error' => 'Unauthorization token'), 401);
        } else {
            $config = array(
                array(
                    'field' => 'no_invoice',
                    'label' => 'No Invoice',
                    'rules' => 'required|trim'
                )
            );

            $this->form_validation->set_data($this->put());
            $this->form_validation->set_rules($config);

            if($this->form_validation->run() == FALSE){

                $this->response(array(
                    'status'    => false,
                    'message'   => 'Field is required',
                    'error'     => $this->form_validation->error_array()
                ), 400);

            } else {
                $where  = array(
                    'no_invoice'   => $this->put('no_invoice') 
                );

                $data = array(
                    'status_invoice' => 'Close',
                );

                $detail = array();

                $edit = $this->InvoiceModel->edit($where, $data, $detail);

                if(!$edit){
                    $this->response(array(
                        'status'    => false,
                        'message'     => 'Failed update invoice'
                    ), 400);
                } else {
                    $this->response(array(
                        'status'    => true,
                        'message'   => 'Success update invoice'
                    ), 200);
                }
            }
        } 
    }

}
