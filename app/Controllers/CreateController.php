<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CreateController extends BaseController
{
    public function index()
    {
        //
    }

    public function savePais(){
        $model = model('PaisesModel');
        $data = $this->request->getPost();
        if($model->insert($data)){
            $response['error']=false;
        }else{
            $response['error']=true;
        }
        return $this->response->setJSON($response);
    }

    public function saveEditorial(){
        $model = model('EditorialModel');
        $data = $this->request->getPost();
        if($model->insert($data)){
            $response['error']=false;
        }else{
            $response['error']=true;
        }
        return $this->response->setJSON($response);
    }

    public function saveAutor(){
        $model = model('AutoresModel');
        $data = $this->request->getPost();
        if($model->insert($data)){
            $response['error']=false;
        }else{
            $response['error']=true;
        }
        return $this->response->setJSON($response);
    }
}
