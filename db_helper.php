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
//UPDATE table SET col = val where condition
    function pdo_update($table, $columns_values, $conditions){
        global $pdo;
        try{
            pdo_connect();
            if ($table){
                if (isAssociative($columns_values) && isAssociative(($conditions))){
                    $q = "update $table SET ";
                    foreach ($columns_values as $col => $v){
                        $q .= "$col = :$col , ";
                    }
                    $q = rtrim($q,", ");
                    $q .= " where ";
                    foreach($conditions as $col => $v){
                        $q .= "$col = :x$col AND ";
                    }
                    $q = rtrim($q,"AND ");
                    // echo $q;
                    $stmt = $pdo->prepare($q);
                    $params = array_merge(
                        $columns_values,
                        array_combine(
                            array_map(
                                function($col){return ":x$col";},array_keys($conditions)
                            ),
                            array_values($conditions)
                        )
                        );
                        // print_r($params);
                    $stmt->execute($params);
                    return $stmt->rowCount();
                    
                }else{  
                    return -2;
                }
            }else{
                return -3;
            }
        } catch(PDOException $e){
            // throw new PDOException($e->getMessage(), (int)$e->getCode());
            return -1;
        }

    }
?>