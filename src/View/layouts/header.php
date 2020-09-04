<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <script src="/resources/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="/resources/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="/resources/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/resources/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/resources/css/style.css">
    <script>
        $(function(){
            $("[data-target='#sign-up']").on("click", function(){
                let canvas = $("#cap_canvas")[0];
                let ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = "#fff";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = "#333";
                ctx.font = "50px 'Segoe UI', sans-serif";
                
                let captcha = Math.random().toString(36).substr(2, 5);
                let txt_width = ctx.measureText(captcha).width;
                ctx.fillText(captcha, canvas.width / 2 - txt_width / 2, canvas.height / 2 + 10);

                $("#cap_answer").val(captcha);
            });
        });
    </script>
</head>
<body>
    <!-- 헤더영역   -->
    <header>
        <div class="container h-100">
            <div class="d-between h-100">
                <div class="d-align-center">
                    <a href="/">
                        <img src="/resources/images/logo.svg" alt="내집꾸미기" title="내집꾸미기" height="40">
                    </a>
                    <div class="nav ml-5 d-none d-lg-flex">
                        <a href="/">홈</a>
                        <a href="/online-party">온라인 집들이</a>
                        <a href="/store">스토어</a>
                        <a href="/experts">전문가</a>
                        <a href="/estimates">시공 견적</a>
                    </div>
                </div>
                <div class="d-align-center">
                    <div class="auth d-none d-lg-flex">
                        <?php if(user()):?>
                            <span class="text-gold fx-n2 mr-2"><?=user()->user_name?>(<?=user()->user_id?>)</span>
                            <a href="/logout">로그아웃</a>
                        <?php else:?>
                            <a href="#" data-toggle="modal" data-target="#sign-in">로그인</a>
                            <a href="#" data-toggle="modal" data-target="#sign-up">회원가입</a>
                        <?php endif; ?>
                    </div>
                    <div class="menu-icon d-lg-none">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="menu d-lg-none">
                        <div class="m-nav">
                            <a href="/">홈</a>
                            <a href="/online-party">온라인 집들이</a>
                            <a href="/store">스토어</a>
                            <a href="/experts">전문가</a>
                            <a href="/estimates">시공 견적</a>
                        </div>
                        <div class="m-auth mt-3">
                        <?php if(user()):?>
                            <span class="text-gold fx-n2 mr-2"><?=user()->user_name?>(<?=user()->user_id?>)</span>
                            <a href="/logout">로그아웃</a>
                        <?php else:?>
                            <a href="#" data-toggle="modal" data-target="#sign-in">로그인</a>
                            <a href="#" data-toggle="modal" data-target="#sign-up">회원가입</a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- /헤더영역 -->

    <!-- 로그인 모달 -->
    <div id="sign-in" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/sign-in" class="modal-content" method="post">
                <div class="modal-body px-4 pt-4">
                    <div class="title text-center">
                        SIGN IN
                    </div>
                    <div class="mt-4 form-group">
                        <label for="login_id">아이디</label>
                        <input type="text" id="login_id" class="form-control" name="user_id" placeholder="아이디를 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="login_pw">비밀번호</label>
                        <input type="password" id="login_pw" class="form-control" name="password" placeholder="비밀번호를 입력하세요" required>
                    </div>
                    <div class="mt-4 form-group">
                        <button class="w-100 py-3 text-white bg-gold hover-opacity">로그인</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /로그인 모달 -->

    <!-- 회원가입 모달 -->
    <div id="sign-up" class="modal fade">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/sign-up" class="modal-content" method="post" enctype="multipart/form-data">
                <div class="modal-body px-4 pt-4">
                    <div class="blue title text-center">
                        SIGN UP
                    </div>
                    <div class="mt-4 form-group">
                        <label for="join_id">아이디</label>
                        <input type="text" id="join_id" class="form-control" name="user_id" placeholder="아이디를 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="join_pw">비밀번호</label>
                        <input type="password" id="join_pw" class="form-control" name="password" placeholder="비밀번호를 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="join_name">이름</label>
                        <input type="text" id="join_name" class="form-control" name="user_name" placeholder="이름을 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="join_photo">사진</label>
                        <div class="custom-file">
                            <input type="file" id="join_photo" name="photo" class="custom-file-input">
                            <label for="join_photo" class="custom-file-label">파일을 업로드 해 주세요</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="cap_answer" name="cap_answer">
                        <canvas id="cap_canvas" class="w-100 border" width="450" height="100"></canvas>
                        <input type="text" id="cap_input" class="form-control" name="cap_input" placeholder="상단의 문자를 입력하세요" required>
                    </div>
                    <div class="mt-4 form-group">
                        <button class="w-100 py-3 text-white bg-blue hover-opacity">회원가입</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /회원가입 모달 -->