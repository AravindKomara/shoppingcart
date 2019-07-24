<?php

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('operation');
    }
    
    public function index(){
        $res['itemdetails'] = $this->operation->commonGet(array(),"item_details","multiple");
        $this->load->view('dashboard',$res);
    }
    
      //common curl API call
    private function common_curl_call($url, $param, $header, $method) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//here we have to give our url
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if ($param != "") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);//checking parameters empty or not empty
        }
        if ($method == "post") {
            curl_setopt($ch, CURLOPT_POST, true);//if method is post
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//here setting header
        $resultcurl = curl_exec($ch);//from API call , result is getting and storing in this variable
      //  print_r($resultcurl);
        curl_close($ch);//closing curl
        return $resultcurl;//returning the data
    }
    
    private function commonImageUpload($imagename,$upload_path){
        if(!empty($_FILES[$imagename]['name'])){
              $config['upload_path'] = "./uploads/users/images";
              $config['allowed_types'] = 'gif|jpg|png|jpeg';//image extensions
              $config['max_size'] = '2000';//image size
              $config['max_width'] = '1500';
              $config['max_height'] = '1500';
              $config['overwrite'] = false;
              $this->load->library('upload', $config);//loading upload library of codeigniter
              $this->upload->initialize($config);  
              if($this->upload->do_upload($imagename)){ // picture is name of your input filed in view  
                  $imageData = $this->upload->data();//getting image details
                  return  $upload_path.$imageData['raw_name'].$imageData['file_ext'];

        }else{
            $error = array('error' => $this->upload->display_errors());
            return $error;
        }
        }
    }
  
   
   public function addToCart(){
       $data = array("item_id"=>$this->input->post('itemID'));
       //print_r($data);exit;
       $res = $this->operation->commonInsert("cart_details",$data);
       //print_r($res);
       if($res){
            $count = count($this->operation->commonGet(array(),"cart_details","multiple"));
            $response['status'] = "1";
            $response['cart_count'] = $count;
            print_r(json_encode($response));
       }
      
   }
   
    public function delteFromCart(){
       $where = array("item_id"=>$this->input->post('itemID'));
       //print_r($data);exit;
       $res = $this->operation->commonDelete($where,"cart_details");
       if($res){
            $count = count($this->operation->commonGet(array(),"cart_details","multiple"));
            $response['status'] = "1";
            $response['cart_count'] = $count;
            print_r(json_encode($response));
       }
      
   }

}
