<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Users\Model;

// use Zend\Db\Sql\Select;
// use Zend\Db\Adapter\Adapter;
// use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class UploadTable{
    protected $tableGateway;
    protected $uploadSharingTableGateway;
    
    public function __construct(TableGateway $tableGateway, TableGateway $uploadSharingTableGateway) {
        $this->tableGateway = $tableGateway;
        $this->uploadSharingTableGateway = $uploadSharingTableGateway;
    }
    
    public function saveUpload(Upload $upload) {
        $data = array(
            'filename' => $upload->filename,
            'label' => $upload->label,
            'user_id' => $upload->user_id
        );
        $id = (int) $upload->id;
        
        if ($id == 0){
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUpload($id)){
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception("Upload id does not exist");
            }
        }
    }
    
    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getUpload($uploadId) {
        $uploadId = (int) $uploadId;
        $rowset = $this->tableGateway->select(array('id' => $uploadId));
        $row = $rowset->current();
        
        if (!$row){
            throw new \Exception("Could not find row $uploadId");
        }
        
        return $row;
    }
    
    public function deleteUpload($uploadId) {
        $this->tableGateway->delete(array('id' => $uploadId));
    }
    
    /*
     * Uploads for user
     */
    public function getUploadsByUserId($userId) {
        $userId = (int) $userId;
        $rowset = $this->tableGateway->select(array('user_id' => $userId));
        return $rowset;
    }
    
   
}