<?php
namespace Controller;

use App\DB;

class UserController {
    function signIn(){
        checkInput();
        extract($_POST);

        $user = DB::who($user_id);
        if(!$user || $user->password !== hash('sha256', $password)) back("아이디 혹은 비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = $user;
        
        go("/", "로그인 되었습니다.");
    }

    function signUp(){
        checkInput();
        extract($_POST);
        extract($_FILES);

        $user = DB::who($user_id);
        if($user) back("중복되는 아이디입니다. 다른 아이디를 사용해주세요.");
        if($cap_answer !== $cap_input) back("자동입력방지 문자를 잘못 입력하였습니다.");

        $filename = time() . extname($photo);
        move_uploaded_file($photo['tmp_name'], _UPLOAD."/users/$filename");

        DB::query("INSERT INTO users(user_id, password, user_name, photo) VALUES (?, ?, ?, ?)", [$user_id, hash('sha256', $password), $user_name, $filename]);

        go("/", "회원가입 되었습니다.");
    }

    function logout(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }

    // 전문가 페이지
    function expertPage(){
        $sql = "SELECT DISTINCT E.*, IF(R.cnt IS NULL, '0', floor(R.total / R.cnt)) score, M.eid reviewed
                FROM users E
                LEFT JOIN (SELECT COUNT(*) cnt, SUM(score) total, eid FROM expert_reviews GROUP BY eid) R ON R.eid = E.id
                LEFT JOIN (SELECT eid FROM expert_reviews WHERE uid = ?) M ON M.eid = E.id
                WHERE E.auth = 1 ORDER BY E.id";
        $experts = DB::fetchAll($sql, [user()->id]);

        $sql = "SELECT DISTINCT R.*, U.user_name, U.user_id, E.user_name e_name, E.user_id e_id
                FROM expert_reviews R
                LEFT JOIN users U ON U.id = R.uid
                LEFT JOIN users E ON E.id = R.eid";
        $reviews = DB::fetchAll($sql);

        view("expert", ["experts" => $experts, "reviews" => $reviews]);
    }
    function reviewExpert(){
        checkInput();
        extract($_POST);

        DB::query("INSERT INTO expert_reviews(uid, eid, contents, price, score) VALUES (?, ?, ?, ?, ?)", [user()->id, $eid, $contents, $price, $score]);
        go("/experts", "후기가 작성되었습니다.");
    }
}