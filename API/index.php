<?php

require_once 'DBObject/Location.php';
require_once 'DBObject/User.php';
require_once 'Session.php';

$postData = $_POST;

$jwt = isset(getallheaders()['jwt']) ? getallheaders()['jwt'] : null;

$userObject = new User();
$locationObject = new Location();
$sessionObject = new Session($jwt);

$response = ['status' => 'error', 'message' => 'Something went wrong...', 'data' => null];

switch ($_GET['apiName']) {
    case 'register':

        if (!empty($postData)) {
            if (isset($postData['firstName']) &&
                isset($postData['lastName']) &&
                isset($postData['emailID']) &&
                isset($postData['password'])) {

                $userData['firstName'] = $postData['firstName'];
                $userData['lastName'] = $postData['lastName'];
                $userData['emailID'] = $postData['emailID'];
                $userData['password'] = md5($postData['password']);

                $insertedID = $userObject->insert($userData);
                if ($insertedID) {
                    $jwt = $sessionObject->encodeJWT([
                        'id' => $insertedID,
                        'emailID' => $userData['emailID'],
                        'time' => time(),
                        'name' => $userData['firstName'] . ' ' . $userData['lastName'],
                    ]);
                    header("jwt: $jwt");

                    $response['status'] = 'success';
                    $response['message'] = 'User has been created successfully...';
                    $response['data']['userID'] = $insertedID;
                }
            } else {
                $response['message'] = 'Input missing';
            }
        } else {
            $response['message'] = 'Input missing';
        }

        break;

    case 'login':

        if (!empty($postData)) {
            if (isset($postData['emailID']) &&
                isset($postData['password'])) {

                $where['emailID'] = $postData['emailID'];
                $where['password'] = md5($postData['password']);

                $userDetails = $userObject->getRecord($where);

                if (isset($userDetails['id'])) {

                    $jwt = $sessionObject->encodeJWT([
                        'id' => $userDetails['id'],
                        'emailID' => $userDetails['emailID'],
                        'time' => time(),
                        'name' => $userDetails['firstName'] . ' ' . $userDetails['lastName'],
                    ]);

                    header("jwt: $jwt");

                    $response['status'] = 'success';
                    $response['message'] = 'Logged in';
                    $response['data'] = $userDetails;

                } else {
                    $response['message'] = 'Invalid credentials';
                }

            } else {
                $response['message'] = 'Input missing';
            }
        } else {
            $response['message'] = 'Input missing';
        }

        break;

    case 'saveLocation':

        if ($sessionObject->isValidJWT()) {
            if (!empty($postData)) {
                if (isset($postData['latitude']) &&
                    isset($postData['longitude']) &&
                    isset($postData['name']) &&
                    isset($postData['description'])) {

                    $locationData['userID'] = $sessionObject->getSessionDetails('id');
                    $locationData['name'] = $postData['name'];
                    $locationData['description'] = $postData['description'];
                    $locationData['latitude'] = $postData['latitude'];
                    $locationData['longitude'] = $postData['longitude'];

                    $insertedID = $locationObject->insert($locationData);
                    if ($insertedID) {
                        $response['status'] = 'success';
                        $response['message'] = 'New location has been saved successfully...';
                        $response['data'] = $insertedID;
                    } else {
                        $response['message'] = 'Something went wrong, while saving your location';
                    }
                } else {
                    $response['message'] = 'Input missing';
                }
            } else {
                $response['message'] = 'Input missing';
            }
        } else {
            $response['message'] = 'Invalid jwt';
            $response['invalidJWT'] = true;
        }

        break;

    case 'getAllSavedLocation':

        if ($sessionObject->isValidJWT()) {

            $limit = $postData['length'];

            $page = ($postData['start'] ? ($postData['start'] / $postData['length']) + 1 : 1);

            $options = ['limit' => (int) $limit, 'offset' => (int) (($page - 1) * $limit)];

            $where = ['userID' => $sessionObject->getSessionDetails('id')];
            $locations = $locationObject->getAllRecord($where, $options);
            $recordsTotal = $filteredRecordCount = $locationObject->getCount($where);

            $dataForTable = [];
            if (!empty($locations)) {
                foreach ($locations as $location) {
                    $dataForTable[] = [
                        'name' => $location['name'],
                        'description' => $location['description'],
                        'latitude' => $location['latitude'],
                        'longitude' => $location['longitude'],
                        'createdAt' => $location['createdAt'],
                        'action' => '<span class="btn btn-sm"><i class="glyphicon glyphicon-trash"></i></span>',
                    ];
                }
            }

            $response = ['recordsTotal' => $recordsTotal, 'recordsFiltered' => $filteredRecordCount, 'draw' => (int) $postData['draw'], 'data' => $dataForTable];

        } else {
            $response['message'] = 'Invalid jwt';
            $response['invalidJWT'] = true;
        }

        break;

    case 'checkJWT':

        $isValid = $sessionObject->isValidJWT();
        $response['message'] = ($isValid ? "Valie" : "Invalid") . ' JWT';
        $response['sessionDetails'] = $isValid;
        $response['validJWT'] = $isValid ? true : false;

        break;

    default:

        break;
}

header('Content-Type: application/json');

if (isset($response['status']) && $response['status'] === 'error') {
    http_response_code(400);
}

if ($jwt) {
    header("jwt: $jwt");
}

echo json_encode($response);
