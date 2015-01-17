<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

include_once APPPATH . 'core/controllers/baseadmin.php';

class Tinymce_media_dialog extends Baseadmin {

    private $upload_dir = "./uploads/";
    private $upload_url = "";

    public function __construct() {
        parent::__construct();
        $this->load->helper("text");
        $this->upload_url = base_url("uploads") . "/";
    }

    /**
     * @author Harry Osmar Sitohang
     * @return json
     * @desc : load tiny mce form upload
     */
    public function tinymce_load_form_upload() {
        echo json_encode($this->view->load("pages/tinymce/form_upload", "", TRUE));
    }

    /**
     * @author Harry Osmar Sitohang
     * @return json
     * @desc : load tiny mce form upload
     */
    public function tinymce_upload_process() {
        $config['upload_path'] = $this->upload_dir;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);

        if ($this->input->post('counter') == 0) {
            echo json_encode(array("status" => "error", "msg" => "please select file to upload"));
        } else {
            $all_li_img = "";
            for ($i = 1; $i <= $this->input->post('counter'); $i++) {
                $filename = 'tinymce_image' . $i;
                if (!$this->upload->do_upload("$filename")) {
                    echo json_encode(array("status" => "error", "msg" => $this->upload->display_errors())); die;
                } else {
                    $upload_data = $this->upload->data();
                    $upload_data['url'] = "{$this->upload_url}{$upload_data["file_name"]}";
                    $all_li_img .= $this->view->load("pages/tinymce/li_map", array("upload_url" => $this->upload_url, "file" => $upload_data["file_name"], "new_upload_file" => TRUE), TRUE); 
                }
            }
            echo json_encode(array("status" => "success", "upload_data" => $upload_data, "li_img" => $all_li_img));
        }
    }

    /**
     * @author Harry Osmar Sitohang
     * @return json
     * @desc : read uploads tinymce directory
     */
    public function read_uploads_dir() {
        $this->load->helper('directory');
        $data = array("upload_dir" => $this->upload_dir, "upload_url" => $this->upload_url, "map" => directory_map($this->upload_dir));
        $map_view_arr = array('map_view' => $this->view->load("pages/tinymce/map", $data, TRUE));
        echo json_encode(array_merge($data, $map_view_arr));
    }

    /**
     * @author Harry Osmar Sitohang
     * @return json
     * @desc : delete selected image get from post ajax
     */
    public function tinymce_delete_process() {
        if ($this->input->post("img")) {
            foreach ($_POST['img'] as $img) {
                $filepath = "{$this->upload_dir}{$img}";
                if (file_exists($filepath)) {
                    unlink($filepath);
                }
            }
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "error", "msg" => "post variable not found"));
        }
    }

}

/* End of file tinymce_media_dialog.php */
/* Location: ./application/controllers/baseadmin/tinymce_media_dialog.php */