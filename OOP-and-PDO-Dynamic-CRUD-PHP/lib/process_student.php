<?php
    include 'Session.php';
    Session ::init();
    include 'Database.php';
    $db = new Database();

    $table = "tbl_student";

    if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) 
    {
        if ($_REQUEST['action'] =='add')   // for Insert ----------------------------
        {
            $studentData = array(
                'name'  => $_POST['name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone']
            );
            $insert = $db->insert($table, $studentData);

            if($insert)
            {
                $msg = "Data Inserted Successfully";
            }
            else
            {
                $msg = "Data not inserted";
            }

            Session::set('msg',$msg);
            $home_url = '../index.php';
            header('Location: '.$home_url);
        }

        elseif ($_REQUEST['action'] =='edit') // for Update  ----------------------------
        {
            $studentId = $_POST['studentId'];
            if (!empty($studentId)) 
            {
                $studentData = array(
                    'name'  => $_POST['name'],
                    'email' => $_POST['email'],
                    'phone' => $_POST['phone']
                );
                
                $table = "tbl_student";
                $condition = array('studentId' => $studentId);
                $update    = $db->update($table, $studentData, $condition); //table already declared watch top               
    
                if($update)
                {
                    $msg = "Data Updated Successfully";
                }
                else
                {
                    $msg = "Data not Updated";
                }

                Session::set('msg',$msg);
                $home_url = '../index.php';
                header('Location: '.$home_url);
            }
        }

        elseif ($_REQUEST['action'] =='delete') // for Delete  ----------------------------
        {
            $studentId = $_GET['studentId'];
            if (!empty($studentId)) 
            {
                $table = "tbl_student";
                $condition = array('studentId' => $studentId);
                $delete    = $db->delete($table, $condition); //table already declared watch top               
    
                if($delete)
                {
                    $msg = "Data Deleted Successfully";
                }
                else
                {
                    $msg = "Data not Deleted";
                }

                Session::set('msg',$msg);
                $home_url = '../index.php';
                header('Location: '.$home_url);
            }
        }



        
    }



        // elseif($_REQUEST['action'] == 'edit') //-----from video ---------
        // { 
        //     $studentId = $_POST['studentId']; 
        //     if (!empty($studentId)) 
        //     { 
        //         $studentData = array( 
        //             'name' =>  $_POST['name'], 
        //             'email' => $_POST['email'], 
        //             'phone' => $_POST['phone'] 
        //         ); 
        //         $table = "tbl student"; 
        //         $condition = array('studentId' => $studentId); 
        //         $update = $db->update($table, $studentData, $condition); 
        //         if ($update) 
        //         { 
        //             $msg = "Data updated Successfully"; 
        //         }
        //         else 
        //         { 
        //             $msg = "Data not updated !"; 
        //         } 
        //         Session::set('msg', $msg); 
        //         $home_url = '../index.php'; 
        //         header('Location: '.$home_url); 
        //     }
        // }


        



?>