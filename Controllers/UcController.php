<?php

namespace Controllers;


use Models\Uc;
use Libraries\Response;
use Libraries\Request;
use Libraries\MessageBroker;

class UcController
{
    /**
     * index
     * @param  array $params
     *
     * @return void
     */
    public function index(array $params = [])
    {
        Request::verifyToken([0]);
        $filter = [];
        if (!empty($params[0])) {
            $filter["code"] = $params[0];
        }
        $info = Uc::find("*", $filter);
        if (empty($info)) {
            Response::sendResponse(200, ["msg" => "No Ucs Found", "info" => []]);
        }
        Response::sendResponse(200, ["msg" => "Ucs Found", "info" => $info]);
    }

    /**
     * insert
     * @param  array $params
     *
     * @return void
     */
    public function insert(array $params = [])
    {
        Request::verifyToken([0]);
        $post = Request::getPostParams();
        if (empty($post['name']) || empty($post['code']) || empty($post['description'])) {
            Response::sendResponse(422, ["msg" => "Parameters not found"]);
        }
        if ($info_exist = Uc::find("*", ["code" => $post['code']])) {
            Response::sendResponse(205, ["msg" => "Uc Already Exist", "id" => $info_exist[0]->iduc]);
        }
        $response = $this->save($post);
        if ($response) {
            MessageBroker::sendMessage(
                "ucCreate",
                [
                    "iduc" => $response,
                    "code" => $post['code'],
                    "name" => $post['name']
                ]
            );
            Response::sendResponse(200, ["msg" => "Inserted Success", "id" => $response]);
        } else {
            Response::sendResponse(422, ["msg" => "Error on insert record"]);
        }
    }

    /**
     * update
     *
     * @param  array $params
     * @return void
     */
    public function update(array $params = [])
    {
        Request::verifyToken([0]);
        $info = $this->checkInfo($params);
        if ($info) {
            $post = Request::getPostParams();
            $post = array_merge((array)$info[0], $post);
            $response = $this->save($post, $info[0]->iduc);
            if ($response) {
                MessageBroker::sendMessage(
                    "ucUpdate",
                    [
                        "iduc" => $info[0]->iduc,
                        "code" => $post['code'],
                        "name" => $post['name']
                    ]
                );
                Response::sendResponse(200, ["msg" => "Updated Success"]);
            } else {
                Response::sendResponse(422, ["msg" => "Error on updated record"]);
            }
        } else {
            Response::sendResponse(404, ["msg" => "Data Not Found"]);
        }
    }


    /**
     * checkInfo
     *
     * @param  array $params
     * @return array
     */
    private function checkInfo(array $params = [])
    {
        if (empty($params)) {
            Response::sendResponse(422, ["msg" => "Parameters not found"]);
        }
        $us = Uc::find("*", ['code' => $params[0]]);
        return $us;
    }


    /**
     * save
     *
     * @param  array $post
     * @param  int $id
     * @return boolean|int
     */
    private function save(array $post, ?int $id = null)
    {
        $uc_class = new Uc();
        $uc_class->name = $post['name'];
        $uc_class->code = $post['code'];
        $uc_class->description = $post['description'];
        if ($id) {
            $uc_class->iduc = $id;
            return $uc_class->update();
        } else {
            return $uc_class->insert();
        }
    }



    /**
     * delete
     *
     * @param  array $params
     * @return void
     */
    public function delete(array $params = [])
    {
        Request::verifyToken([0]);
        $us = $this->checkInfo($params);
        if (!$us) {
            Response::sendResponse(404, ["msg" => "Data Not Found"]);
        }
        $uc_class = new Uc();
        $uc_class->iduc = $us[0]->iduc;
        if ($uc_class->delete()) {
            MessageBroker::sendMessage(
                "ucDelete",
                [
                    "iduc" => $us[0]->iduc
                ]
            );
            Response::sendResponse(200, ["msg" => "Delete Success"]);
        } else {
            Response::sendResponse(422, ["msg" => "Error on delete record"]);
        }
    }
}
