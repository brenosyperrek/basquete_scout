<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));

switch ($path[0] ?? '') {
    case 'salvar':
        if ($method != 'POST') exit();
        $d = json_decode(file_get_contents('php://input'), true);
        $sql = "INSERT INTO jogos (data,adversario,nome_jogador,min,pts,fgm,fga,tpm,tpa,ftm,fta,oro,dre,reb,ast,stl,blk,tov,pf,ef,pts_40,reb_40,ast_40,ef_40,fgp,tpp,ftp)
                VALUES (:dt,:adv,:nome,:min,:pts,:fgm,:fga,:tpm,:tpa,:ftm,:fta,:oro,:dre,:reb,:ast,:stl,:blk,:tov,:pf,:ef,:p40,:r40,:a40,:e40,:fgp,:tpp,:ftp)";
        $params = [
            ':dt'=>$d['data'],':adv'=>$d['adversario'],':nome'=>$d['nome'],':min'=>$d['min'],':pts'=>$d['pts'],
            ':fgm'=>$d['fgm'],':fga'=>$d['fga'],':tpm'=>$d['tpm'],':tpa'=>$d['tpa'],':ftm'=>$d['ftm'],':fta'=>$d['fta'],
            ':oro'=>$d['oro'],':dre'=>$d['dre'],':reb'=>$d['reb'],':ast'=>$d['ast'],':stl'=>$d['stl'],':blk'=>$d['blk'],
            ':tov'=>$d['tov'],':pf'=>$d['pf'],':ef'=>$d['ef'],':p40'=>$d['pts_40'],':r40'=>$d['reb_40'],':a40'=>$d['ast_40'],
            ':e40'=>$d['ef_40'],':fgp'=>$d['fgp'],':tpp'=>$d['tpp'],':ftp'=>$d['ftp']
        ];
        dbExec($sql, $params);
        http_response_code(201);
        echo json_encode(['ok'=>true]);
        break;

    case 'listar':
        if ($method != 'GET') exit();
        $r = dbQuery("SELECT id,data,adversario,nome_jogador,min,pts,reb,ast,ef FROM jogos ORDER BY data DESC, id DESC");
        echo json_encode($r);
        break;

    case 'buscar':
        $id = intval($path[1] ?? 0);
        if ($method != 'GET' || !$id) exit();
        $r = dbQuery("SELECT * FROM jogos WHERE id = :id", [':id'=>$id]);
        echo json_encode($r[0] ?? []);
        break;

    default:
        http_response_code(404);
        echo json_encode(['erro'=>'Rota não encontrada']);
}
?>
