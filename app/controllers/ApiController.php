<?php

class ApiController extends \Phalcon\Mvc\Controller
{
    public function listUserAction()
    {
        $usersArray = [];
        $this->view->disable();
        $users = Users::find([
                'columns' => 'id, firstName, lastName, email, gender, details, hobby, fileName'
            ]);
        foreach ($users as $user) {
            $user->hobby = empty($user->hobby) ? [] : unserialize($user->hobby);
            $usersArray[] = $user;
        }
        $this->response->setJsonContent($usersArray);
        $this->response->setStatusCode(200, "OK");
        $this->response->send();
    }

    public function getUserAction()
    {
        $this->view->disable();
        $userId = $this->dispatcher->getParam("id");
        $users = Users::findFirst([
                'conditions' => 'id = '.$userId,
                'columns' => 'id, firstName, lastName, email, gender, details, hobby, fileName'
            ]);
        if (!$users->id) {
            $this->response->setJsonContent(['status' => 'error', 'data' => 'user not found']);
            $this->response->setStatusCode(401);
            $this->response->send();
        } else {
            $users->hobby = empty($users->hobby) ? [] : unserialize($users->hobby);
            $this->response->setJsonContent($users);
            $this->response->setStatusCode(200, "OK");
            $this->response->send();
        }
    }

    public function createUserAction()
    {
        $this->view->disable();
        $inputData = $this->request->getJsonRawBody();
        $messages = Users::getValidator()->validate($inputData);
        if (count($messages)) {
            $errors = [];
            foreach ($messages as $message) {
                $errors[] = ['message' => $message->getMessage(), 'field' => $message->getField()];
            }
            $this->response->setJsonContent(['status' => 'error', 'data' => $errors]);
            $this->response->setStatusCode(401, 'validation fail');
            $this->response->send();
        } else {
            $user = new Users();
            $user->firstName = $inputData->firstName;
            $user->lastName = $inputData->lastName;
            $user->email = $inputData->email;
            $user->password = md5($inputData->password);
            $user->gender = $inputData->gender;
            $user->details = $inputData->details;
            $user->hobby = serialize($inputData->hobby);
            if ($inputData->image->filetype == 'image/jpeg') {
                $user->fileName = '.jpg';
            } else {
                $user->fileName = '.png';
            }
            $user->create();
            file_put_contents('files/'.$user->id.$user->fileName, base64_decode($inputData->image->base64));
            $this->response->setJsonContent(['status' => 'success', 'data' => 'user added']);
            $this->response->setStatusCode(200, "OK");
            $this->response->send();
        }
    }

    public function editUserAction()
    {
        $this->view->disable();
        $inputData = $this->request->getJsonRawBody();
        $userId = $this->dispatcher->getParam("id");
        $user = Users::findFirst($userId);
        $messages = Users::getValidator(false)->validate($inputData);
        if (!$user->id) {
            $this->response->setJsonContent(['status' => 'error', 'data' => 'user not found']);
            $this->response->setStatusCode(401);
            $this->response->send();
        } else if (count($messages)) {
            $errors = [];
            foreach ($messages as $message) {
                $errors[] = ['message' => $message->getMessage(), 'field' => $message->getField()];
            }
            $this->response->setJsonContent(['status' => 'error', 'data' => $errors]);
            $this->response->setStatusCode(401, 'validation fail');
            $this->response->send();
        } else {
            $user->firstName = $inputData->firstName;
            $user->lastName = $inputData->lastName;
            $user->email = $inputData->email;
            $user->gender = $inputData->gender;
            $user->details = $inputData->details;
            $user->hobby = serialize($inputData->hobby);
            $user->save();
            $this->response->setJsonContent(['status' => 'success', 'data' => 'user updated']);
            $this->response->setStatusCode(200, "OK");
            $this->response->send();
        }
    }

    public function deleteUserAction()
    {
        $this->view->disable();
        $userId = $this->dispatcher->getParam("id");
        $user = Users::findFirst($userId);
        $user->delete();
        $this->response->setJsonContent(["status" => "success", "data" => "user deleted successfully!!"]);
        $this->response->setStatusCode(200, "OK");
        $this->response->send();
    }
}
