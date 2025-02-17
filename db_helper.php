<?php
    include_once('config.php');
    $pdo=NULL;
function isAssociative(array $arr): bool {
    return array_keys($arr) !== range(0, count($arr) - 1);
}
    function pdo_connect(){
        global $pdo;
        try{

        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

    }
    function pdo_select($table, $condition = [],$fetchAll = true){
        global $pdo;
        pdo_connect();
        $q = "";
        try{

        if ($table){
            $q = "select * from $table";
            if ($condition && isAssociative($condition)){
                $q.=" where ";
                $whereClauses = [];
                foreach ($condition as $col => $v){
                    $whereClauses[] = " $col = :$col ";
                }
                $q.= implode(" AND ", $whereClauses);

            }   
            $stmt = $pdo->prepare($q);
            $stmt->execute($condition);

        return $fetchAll ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return [];
        }

    }catch(PDOException $e){
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    }
    function pdo_insert($table, $columns_values){
        global $pdo;
        try{
        pdo_connect();
        $placeholders = [];
        foreach ($columns_values as $col => $v){
            $placeholders[":$col"] = $v;
        }
        $columns = implode(", ", array_keys($columns_values));
        $placeholdersStr = implode(", ", array_keys($placeholders));
        $q = "insert into $table ($columns) VALUES($placeholdersStr)";
        $stmt = $pdo->prepare($q);
        $stmt->execute($placeholders);
        return $pdo->lastInsertId();
    }catch(PDOException $e){
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    }
?>