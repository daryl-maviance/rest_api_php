<?php

class UserController
{
    public function __construct(private UserGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            $user = $this->gateway->getUser($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['message' => 'User not found']);
                return;
            }

            switch ($method) {
                case 'GET':
                    echo json_encode($user);
                    break;
                case 'PUT':
                    $data = json_decode(file_get_contents('php://input'), true);
                    $updated = $this->gateway->update($id, $data);
                    echo json_encode($updated);
                    break;
                case 'DELETE':
                    $deleted = $this->gateway->delete($id);
                    http_response_code($deleted ? 204 : 404);
                    break;
                default:
                    http_response_code(405);
                    break;
            }
        } else {
            switch ($method) {
                case 'GET':
                    $users = $this->gateway->getAll();
                    echo json_encode($users);
                    break;
                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    $id = $this->gateway->create($data);
                    echo json_encode([
                        'message' => 'Created successfully',
                        'id' => $id
                    ]);
                    http_response_code(201);
                    break;
                default:
                    http_response_code(405);
                    break;
            }
        }
    }
}
?>