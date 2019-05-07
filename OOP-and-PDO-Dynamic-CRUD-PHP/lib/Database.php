<?php

class Database
{
    private $hostdb = "localhost";
    private $userdb = "root";
    private $passdb = "";
    private $namedb = "db_student_pdo";
    private $pdo;

    public function __construct()
    {
        if (!isset($this->pdo)) 
        {
            try 
            {
                $link = new PDO("mysql:host=".$this->hostdb.";dbname=".$this->namedb,$this->userdb,$this->passdb);
                $link -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $link -> exec("SET CHARACTER SET utf8");
                $this->pdo = $link;
            } 
            catch (PDOException $e) 
            {
                die("Failed to connect with Database".$e->getMessage()); //if face any error then it stop by this 'die'  method
            }
        }
    }

    // Read Data
    /*
    $sql = "SELECT *FROM tableName WHERE studentId=:studentId AND email=:email LIMIT 1 ";
    $query = $this->pdo->prepare($sql);
    $query->bindValue(':studentId',$studentId );
    $query->bindValue(':email',$email );
    $query->execute();
    */
    public function select($table, $data= array())
    {
        $sql = 'SELECT';
        $sql .= array_key_exists("select", $data) ? $data['select']:'*';
        $sql .= ' FROM '.$table;
        
        if (array_key_exists("where",$data)) 
        {
            $sql .= ' WHERE ';
            $i = 0;
            foreach ($data['where'] as $key => $value) 
            {
                $add = ($i > 0) ? ' AND ' : '' ;
                $sql .= "$add"."$key=:$key";
                $i++;
            }
        }

        if (array_key_exists("order_by",$data)) //-----> 1
        {
            $sql .= ' ORDER BY '.$data['order_by'];
        }

        
        if (array_key_exists("start",$data) && array_key_exists("limit",$data)) //-----> 3
        {
            $sql .= ' LIMIT '.$data['start']. ','.$data['limit'];
        }
        elseif (!array_key_exists("start",$data) && array_key_exists("limit",$data)) 
        {
            $sql .= ' LIMIT '.$data['limit'];
        }

        $query = $this->pdo->prepare($sql);



        if (array_key_exists("where",$data))  //-----> 2
        {
            foreach ($data['where'] as $key => $value) 
            {
                $query->bindValue(":$key", $value);
            }
        }
        $query->execute(); 


        if (array_key_exists("return_type",$data)) 
        {
            switch ($data['return_type']) 
            {
                case 'count':
                    $value = $query->rowCount();
                    break;
                
                case 'single':
                    $value = $query->fetch(PDO::FETCH_ASSOC);
                    break;    

                default:
                    $value= '';
                    break;
            }
        }
        else 
        {
            if ($query->rowCount() > 0) 
            {
                $value = $query->fetchAll();
            }
        }

        return !empty($value) ? $value:false;

    }



    // Insert Data
    /*
    $sql = "INSERT INTO tableName (name,email) VALUES (:name, :email)";
    $query =$this->pdo->prepare($sql);
    $query->bindValue(':name',$name);
    $query->bindValue(':email',$email);
    $query->execute();
    */
    public function insert($table, $data)
    {
        if (!empty($data) && is_array($data)) 
        {
            $keys  = '';
            $values= '';

            $keys   = implode(',' , array_keys($data));
            $values = ":".implode(', :' , array_keys($data));
            $sql    = "INSERT INTO ".$table." (".$keys.") VALUES (".$values.")";
            $query  = $this->pdo->prepare($sql);

            foreach ($data as $key => $val) 
            {
                $query->bindValue(":$key",$val);
            }

            $insertdata = $query->execute();
            if ($insertdata) 
            {
                $lastId = $this->pdo->lastInsertId();
                return $lastId;
            }
            else 
            {
                return false;
            }
        }
    }

    // Update Data
    /*
    $sql = "UPDATE tableName SET name=:name, email=:email WHERE id=:id";
                                 name=:name, email=:email, phone=:phone -->using die
    $query =$this->pdo->prepare($sql);
    $query->bindValue(':name',$name);
    $query->bindValue(':email',$email);
    $query->bindValue(':studentId',$studentId);
    $query->execute();
    */
     public function update($table, $data, $condition)
    {
        if (!empty($data) && is_array($data)) 
        {
            $keyValue  = '';
            $whereCond = '';
            $i  = 0 ;
            foreach ($data as $key => $val) 
            {
                $add = ($i > 0) ? ', ' : '' ;
                $keyValue .= "$add"."$key=:$key";
                $i++;
            }
            // echo $keyValue;
            // die();   //  ---->> name=:name, email=:email, phone=:phone

            if (!empty($condition) && is_array($condition))
            {
                $whereCond .= ' WHERE ';
                $i = 0;
                foreach ($condition as $key => $val)
                {
                    $add = ($i > 0) ? ' AND ':'' ;
                    $whereCond .= "$add"."$key=:$key";
                    $i++;
                } 
            }
            // echo $whereCond;
            // die();  //  --->> WHERE studentId=:studentId

            $sql = "UPDATE ".$table." SET ".$keyValue.$whereCond;
            $query  = $this->pdo->prepare($sql);

            foreach ($data as $key => $val) 
            {
                $query->bindValue(":$key",$val);
            }

            foreach ($condition as $key => $val) 
            {
                $query->bindValue(":$key",$val);
            }

            $update = $query->execute();

            return $update?$query->rowCount():false;
        }
        else 
        {
            return false;
        }
    }


    // public function update($table, $data, $cond)  //-----from video 
    // { 
    //     if (!empty($data) && is_array($data)) 
    //     { 
    //         $keyvalue = ''; $whereCond = ''; 
    //         $i = 0; 
    //         foreach ($data as $key => $val) 
    //         { 
    //             $add = ($i > 0)?', ':''; 
    //             $keyvalue .= "$add"."$key=:$key"; 
    //             $i++; 
    //         } //echo $keyvalue; die(); 
    //         if (!empty($cond) && is_array($cond)) 
    //         { 
    //             $whereCond .= ' WHERE '; $i = 0; 
    //             foreach ($cond as $key => $val) 
    //             { 
    //                 $add = ($i > 0)?' AND ':''; 
    //                 $whereCond .= "$add"."$key=:$key"; 
    //                 $i++; 
    //             } 
    //         } 
    //         $sql = "UPDATE ".$table." SET ".$keyvalue.$whereCond; 
    //         $query = $this->pdo->prepare($sql); 

    //         foreach ($data as $key => $val) 
    //         { 
    //             $query->bindValue(":$key", $val); 
    //         } 

    //         foreach ($cond as $key => $val) 
    //         { 
    //             $query->bindValue(":$key", $val); 
    //         } 

    //         $update = $query->execute(); 
    //         return $update?$query->rowCount():false; 
    //     } 
    //     else 
    //     { 
    //         return false; 
    //     }
    // }    
             
        




    // Delete Data
    /*
    $sql = "DELETE FROM tableName WHERE studentId=:studentId";
    $query =$this->pdo->prepare($sql);
    $query->bindValue(':studentId',$studentId);
    $query->execute();
    */
    public function delete($table, $data)
    {
        if (!empty($data) && is_array($data))
        {
            $whereCond = ' WHERE ';  //according to video here a dot. after-  $whereCond .= ' WHERE '; 
            $i = 0;
            foreach ($data as $key => $val)
            {
                $add = ($i > 0) ? ' AND ':'' ;
                //$whereCond .= $add.$key." = '".$val."' ";
                $whereCond .= "$add"."$key=:$key";
                $i++;
            }
        }

        $sql = "DELETE FROM ".$table.$whereCond;
/*       
        $delete = $this->pdo->exec($sql);
        return $delete?true:false;
*/
        $query = $this->pdo->prepare($sql);
        foreach ($data as $key => $val) 
        {
            $query->bindValue(":$key",$val);
        }
        $delete = $query->execute(); 
        return $delete?true:false;              
    }
    
    


}



?>