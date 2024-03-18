<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Libraries\Ciqrcode;
use App\Models\QR_model;
use Kenjis\CI3Compatible\Core\CI_Input;
require_once APPPATH . "Libraries/Ciqrcode.php";
use function bin2hex;
use function file_exists;
use function mkdir;
#[\AllowDynamicProperties]
/**
 * @property Home_model $home_model
 * @property Ciqrcode $ciqrcode
 * @property CI_Input $input
 */
class QRController extends BaseController{
    function __construct(){
        $this->QR_model = new QR_model();
        $this->ciqrcode = new Ciqrcode();
    }
    
    public function index(){
        $data['title']   = 'Codeigniter 4 - QR Code';
        $data['qr_list'] = $this->QR_model->fetch_datas();
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/content', $data);
        $this->load->view('frontend/footer', $data);
    }

    public function generate_qrcode($userid,$data){
        $hex_data   = bin2hex($data);
        $save_name  = $userid.'_'.$hex_data . '.png';
        $dir = "./assets/SavingsUpload/QRCode/";
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }

        /* QR Configuration  */
        $config['cacheable']    = true;
        $config['imagedir']     = $dir;
        $config['quality']      = true;
        $config['size']         = '1024';
        $config['black']        = [255, 255, 255];
        $config['white']        = [255, 255, 255];
        $this->ciqrcode->initialize($config);

        /* QR Data  */
        $params['data']     = $data;
        $params['level']    = 'L';
        $params['size']     = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $save_name;
        $this->ciqrcode->generate($params);
        
        /* Return Data */
        return [
            'content' => $data,
            'file'    => $dir . $save_name,
            'name'    => $save_name
        ];
    }

    public function add_data($qrlink = '',$user_id = ''){
        $data = isset($_REQUEST['qrtext'])?$_REQUEST['qrtext']:$qrlink;
        $userid = isset($_REQUEST['userid'])?$_REQUEST['userid']:$user_id;
        $qr   = $this->generate_qrcode($userid,$data);
        $this->QR_model->insert_data($qr['name'],$userid);
    }

    public function edit_data($id){
        $old_data = $this->QR_model->fetch_data($id);
        $old_file = FCPATH . $old_data['file'];
        $data = $this->input->post('content');
        $qr   = $this->generate_qrcode($data);
        if ($this->QR_model->update_data($id, $old_file, $qr)) {
            $this->modal_feedback('success', 'Success', 'Edit Data Success', 'OK');
        } else {
            $this->modal_feedback('error', 'Error', 'Edit Data Failed', 'Try again');
        }
        return redirect()->to(site_url('/'));
    }

    public function remove_data($id){
        $qr_data = $this->QR_model->fetch_data($id);
        $qr_file = $qr_data['file'];
        if ($this->QR_model->delete_data($id, $qr_file)) {
            $this->modal_feedback('success', 'Success', 'Delete Data Success', 'OK');
        } else {
            $this->modal_feedback('error', 'Error', 'Delete Data Failed', 'Try again');
        }
        return redirect()->to(site_url('/'));
    }
}
