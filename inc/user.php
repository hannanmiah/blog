<?php

class User
{

    public function register($db, $user)
    {
        if ($this->isExist($db, $user['username'])) {
            return "<div class='alert alert-danger'>User already registered! Try a different one!</div>";
        } else {
            $sql="INSERT INTO $db->table (fullname,username,email,password) VALUES (:fullname,:username,:email,:password);";
            $stmt=$db->prepare($sql);
            $stmt->bindParam(':fullname', $user['fullname']);
            $stmt->bindParam(':username', $user['username']);
            $stmt->bindParam(':email', $user['email']);
            $stmt->bindParam(':password', $user['password']);
            $stmt->execute();
            if ($stmt->rowCount()>0) {
                return "<div class='alert alert-success'>Registration Successful!</div>";
            } else {
                return "<div class='alert alert-danger'>Register faild! Something error occured!</div>";
            }
        }
    }

    public function login($db, $user)
    {
        $user['password']=md5($user['password']);
        $sql="SELECT * FROM $db->table WHERE username=:username AND password=:password;";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':username', $user['username']);
        $stmt->bindParam(':password', $user['password']);
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            $data=$this->fetch($db, 'username', $user['username']);
            Session::init();
            Session::set('login', true);
            Session::set('id', $data['id']);
            Session::set('username', $user['username']);
            Session::set('msg', 'Successfully logged in!');

            if (isset($user['auto']) && !empty($user['auto'])) {
                setcookie('username', $user['username'], time()+(3600*24*30));
                setcookie('password', $user['password'], time()+(3600*24*30));
            }

            header('location: index.php');

            return "Login Successful!";
        } else {
            return "<div class='alert alert-danger'>Incorrect password or username! Try again!</div>";
        }
    }

    public function autoLogin($db, $user)
    {
        $sql="SELECT * FROM $db->table WHERE username=:username AND password=:password;";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':username', $user['username']);
        $stmt->bindParam(':password', $user['password']);
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            $data=$this->fetch($db, 'username', $user['username']);
            Session::init();
            Session::set('login', true);
            Session::set('id', $data['id']);
            Session::set('username', $user['username']);
            Session::set('msg', 'Successfully logged in!');
        } else {
            header('Location: login.php');
        }
    }

    private function isExist($db, $user)
    {
        $sql="SELECT * FROM $db->table WHERE username=:username;";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':username', $user);
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            return true;
        } else {
            return false;
        }
    }

    public function fetch($db, $col, $val)
    {
        $sql="SELECT * FROM $db->table WHERE $col=:val;";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':val', $val);
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            $data=$stmt->fetch();

            return $data;
        } else {
            return false;
        }
    }

    public function submitInfo($db, $info)
    {
        $sql="INSERT INTO $db->table (id,image,address,skill,quote) VALUES (:id,:image,:address,:skill,:quote);";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':id', $info['id']);
        $stmt->bindParam(':image', $info['image']);
        $stmt->bindParam(':address', $info['address']);
        $stmt->bindParam(':quote', $info['quote']);
        $stmt->execute();

        if ($stmt->rowCount()>0) {
            echo "Profile updated!";
        } else {
            echo "Error occured!";
        }
    }

    public function showInfo($db, $user_id)
    {
        $sql="SELECT * FROM $db->table WHERE id='$user_id';";
        $stmt=$db->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount()>0) {
            $info=$stmt->fetch();
            return $info;
        } else {
            return "Data not found!";
        }
    }

    public function insertProfile($db, $info)
    {
        $sql="INSERT INTO $db->table (id,address,skill,quote) VALUES (:id,:address,:skill,:quote);";
        $stmt=$db->prepare($sql);
        $stmt->bindParam(':id', $info['id']);
        $stmt->bindParam(':address', $info['address']);
        $stmt->bindParam(':skill', $info['skill']);
        $stmt->bindParam(':quote', $info['quote']);
        $stmt->execute();
        if ($stmt->rowCount()>0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProfile($db, $info)
    {
        $skill=$info['skill'];
        $address=$info['address'];
        $quote=$info['quote'];
        $id=$info['id'];
        try {
            $sql="UPDATE $db->table SET address=:address, skill=:skill, quote=:quote WHERE id=:id;";
            $stmt= $db->prepare($sql);
            $stmt->bindParam(':address', $info['address'], PDO::PARAM_STR);
            $stmt->bindParam(':skill', $info['skill'], PDO::PARAM_STR);
            $stmt->bindParam(':quote', $info['quote'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $info['id'], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount()>0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error! ".$e->getMessage();
            return false;
        }
    }

    public function uploadImage($file)
    {
        $permitted=[$file['permitted'][0],$file['permitted'][1],$file['permitted'][2]];
        $ext=strtolower($file['ext']);
        if (!in_array($ext, $permitted)) {
            return "Only ".implode(',', $file['permitted'])." are allowed!";
        } else {
            if ($file['error']==UPLOAD_ERR_OK) {
                if (move_uploaded_file($file['temp'], $file['path'])) {
                    return true;
                } else {
                    return "failed to upload file! please, try again!";
                }
            } elseif ($file['error']==UPLOAD_ERR_INI_SIZE) {
                return "Maximum file size upload limit is 8MB! ";
            } elseif ($file['error']==UPLOAD_ERR_NO_FILE) {
                return "No file was selected!";
            } elseif ($file['error']==UPLOAD_ERR_CANT_WRITE) {
                return "Can't write this file!";
            } elseif ($file['error']==UPLOAD_ERR_EXTENSION) {
                return "Incorrect File type!";
            }
        }
    }

    public function insertImage($db, $data, $file)
    {
        $res=$this->uploadImage($file);
        if (is_bool($res)) {
            $sql="UPDATE $db->table SET ".$data['col']."=:val WHERE id=:id;";
            try {
                $stmt=$db->prepare($sql);
                $stmt->bindParam(':val', $data['val']);
                $stmt->bindParam(':id', $data['id']);
                $stmt->execute();

                if ($stmt->rowCount()>0) {
                    return true;
                } else {
                    return "There was an error inserting data!";
                }
            } catch (PDOException $e) {
                return "Error! ".$e->getMessage();
            }
        } else {
            return $res;
        }
    }
}
