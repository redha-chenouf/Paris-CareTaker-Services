<?php

require __DIR__ . '/entities/utilisateur/utilisateur.php';
require __DIR__ . '/entities/bien/bien.php';
require __DIR__ . '/entities/prestation/prestation.php';
require __DIR__ . '/entities/occupation/occupation.php';
require __DIR__ . '/entities/intervention/intervention.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$resource = isset($request[0]) ? $request[0] : null;
$id = isset($request[1]) ? $request[1] : null;

switch ($resource) {
    case 'utilisateur':
        handleUtilisateur($method, $id);
        break;
    case 'bien':
        handleBien($method, $id);
        break;
    case 'prestation':
        handlePrestation($method, $id);
        break;
    case 'occupation':
        handleOccupation($method, $id);
        break;
    case 'login': // Assurez-vous que ce cas est présent
        handleLogin($method);
        break;
    case 'intervention':
        handleIntervention($method, $id);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Resource not found']);
        break;
}


function handleLogin($method) {
    if ($method === 'POST') {
        login();
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['error' => 'Invalid request method']);
    }
}

function handleUtilisateur($method, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $utilisateur = getUtilisateur($id);
                if ($utilisateur) {
                    http_response_code(200);
                    echo json_encode($utilisateur);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Utilisateur non trouvé']);
                }
            } else {
                $utilisateurs = getAllUtilisateurs();
                http_response_code(200);
                echo json_encode($utilisateurs);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $result = createUtilisateur($data);
            if ($result) {
                http_response_code(201); // Created
                echo json_encode(["Utilisateur créer avec succès"]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'error' => 'Échec de la création de l\'utilisateur']);
            }
            break;
        case 'PUT':
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $result = updateUtilisateur($id, $data);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la mise à jour de l\'utilisateur']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $result = deleteUtilisateur($id);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la suppression de l\'utilisateur']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
    }
}

function handleBien($method, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $bien = getBien($id);
                if ($bien) {
                    http_response_code(200);
                    echo json_encode($bien);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Bien non trouvé']);
                }
            } else {
                $biens = getAllBiens();
                http_response_code(200);
                echo json_encode($biens);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $result = createBien($data);
            if ($result) {
                http_response_code(201); // Created
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'error' => 'Échec de la création du bien']);
            }
            break;
        case 'PUT':
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $result = updateBien($id, $data);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la mise à jour du bien']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $result = deleteBien($id);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la suppression du bien']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
    }
}

function handlePrestation($method, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $prestation = getPrestation($id);
                if ($prestation) {
                    http_response_code(200);
                    echo json_encode($prestation);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Prestation non trouvée']);
                }
            } else {
                $prestations = getAllPrestations();
                http_response_code(200);
                echo json_encode($prestations);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $result = createPrestation($data);
            if ($result) {
                http_response_code(201); // Created
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'error' => 'Échec de la création de la prestation']);
            }
            break;
        case 'PUT':
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $result = updatePrestation($id, $data);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la mise à jour de la prestation']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $result = deletePrestation($id);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la suppression de la prestation']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
    }
}

function handleOccupation($method, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $occupation = getOccupation($id);
                if ($occupation) {
                    http_response_code(200);
                    echo json_encode($occupation);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Occupation non trouvée']);
                }
            } else {
                $occupations = getAllOccupations();
                http_response_code(200);
                echo json_encode($occupations);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $result = createOccupation($data);
            if ($result) {
                http_response_code(201); // Created
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'error' => 'Échec de la création de l\'occupation']);
            }
            break;
        case 'PUT':
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $result = updateOccupation($id, $data);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la mise à jour de l\'occupation']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $result = deleteOccupation($id);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la suppression de l\'occupation']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
    }
}

function handleIntervention($method, $id) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $intervention = getIntervention($id);
                if ($intervention) {
                    http_response_code(200);
                    echo json_encode($intervention);
                } else {
                    http_response_code(404);
                    echo json_encode(['error' => 'Intervention non trouvée']);
                }
            } else {
                $interventions = getAllInterventions();
                http_response_code(200);
                echo json_encode($interventions);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $result = createIntervention($data);
            if ($result) {
                http_response_code(201); // Created
                echo json_encode(['success' => true]);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['success' => false, 'error' => 'Échec de la création de l\'intervention']);
            }
            break;
        case 'PUT':
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $result = updateIntervention($id, $data);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la mise à jour de l\'intervention']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $result = deleteIntervention($id);
                if ($result) {
                    http_response_code(200); // OK
                    echo json_encode(['success' => true]);
                } else {
                    http_response_code(500); // Internal Server Error
                    echo json_encode(['success' => false, 'error' => 'Échec de la suppression de l\'intervention']);
                }
            } else {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'ID manquant']);
            }
            break;
    }
}
