<?php

class CustomerController
{
    public function __construct(private CustomerGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {
            $customer = $this->gateway->getCustomer($id);
            if (!$customer) {
                http_response_code(404);
                echo json_encode(['message' => 'Customer not found']);
                return;
            }

            switch ($method) {
                case 'GET':
                    echo json_encode($customer);
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
                    $customers = $this->gateway->getAll();
                    echo json_encode($customers);
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
