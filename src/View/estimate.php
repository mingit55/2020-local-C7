<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px">
    <div class="design-line"></div>
    <div class="design-line"></div>
    <div class="images">
        <img src="./resources/images/slides/2.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    </div>
    <div class="position-center text-center">
        <div class="text-white fx-7 segoe font-weight-bolder">ESTIMATES</div>
        <div class="fx-1 text-gray">지금 바로 당신의 이상을 전문가에게 맡겨보세요</div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 요청 목록 -->
<div class="container padding">
    <div class="sticky-top pt-4 bg-white mb-4">
        <div class="d-between">
            <div>
                <span class="text-muted">시공 견적 요청</span>
                <div class="title">REQUESTS</div>
            </div>
            <button class="button-label" data-toggle="modal" data-target="#request-modal">견적 요청</button>
        </div>
        <div class="table-head mt-4">
            <div class="cell-10">상태</div>
            <div class="cell-40">내용</div>
            <div class="cell-15">요청자</div>
            <div class="cell-15">시공일</div>
            <div class="cell-10">견적 개수</div>
            <div class="cell-10">+</div>
        </div>
    </div>
    <div class="list">
        <?php foreach($reqList as $req):?>
        <div class="table-item">
            <div class="cell-10">
                <?php if($req->sid):?>
                    <span class="px-3 py-2 text-white bg-gold fx-n2 rounded-pill">완료</span>
                <?php else:?>
                    <span class="px-3 py-2 text-white bg-gold fx-n2 rounded-pill">진행 중</span>
                <?php endif;?>
            </div>
            <div class="cell-40">
                <p class="fx-n2 text-muted"><?=nl2br(htmlentities($req->contents))?></p>
            </div>
            <div class="cell-15">
                <span><?=$req->user_name?></span>
                <small class="text-muted">(<?=$req->user_id?>)</small>
            </div>
            <div class="cell-15">
                <span class="text-muted fx-n1"><?=$req->start_date?></span>
            </div>
            <div class="cell-10">
                <span class="text-muted fx-n1"><?=$req->cnt?></span>
            </div>
            <div class="cell-10">
                <?php if($req->uid == user()->id):?>
                    <button class="fx-n2 px-2 py-2 text-white bg-blue hover-opacity" data-toggle="modal" data-id="<?=$req->id?>" data-target="#view-modal">
                        견적 보기
                    </button>
                <?php elseif(!$req->sended && user()->auth && !$req->sid):?>
                    <button class="fx-n2 px-2 py-2 text-white bg-blue hover-opacity" data-toggle="modal" data-id="<?=$req->id?>" data-target="#response-modal">
                        견적 보내기
                    </button>
                <?php else :?>
                        -
                <?php endif;?>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!--/ 요청 목록 -->


<!-- 보낸 목록 -->
<?php if(user()->auth):?>
<div class="bg-gray">
    <div class="container padding">
        <div class="sticky-top pt-4 bg-gray">
            <div>
                <span class="text-muted">보낸 견적</span>
                <div class="title blue">RESPONSES</div>
            </div>
            <div class="table-head mt-4">
                <div class="cell-10">상태</div>
                <div class="cell-40">내용</div>
                <div class="cell-15">요청자</div>
                <div class="cell-15">시공일</div>
                <div class="cell-10">입력한 비용</div>
                <div class="cell-10">+</div>
            </div>
        </div>
        <div class="list">
            <?php foreach($resList as $res):?>
            <div class="table-item">
                <div class="cell-10">
                    <?php if(!$res->sid):?>
                        <span class="px-3 py-2 text-white bg-blue fx-n2 rounded-pill">진행 중</span>
                    <?php elseif($res->sid == $res->id):?>
                        <span class="px-3 py-2 text-white bg-blue fx-n2 rounded-pill">선택</span>
                    <?php else :?>
                        <span class="px-3 py-2 text-white bg-blue fx-n2 rounded-pill">미선택</span>
                    <?php endif;?>
                </div>
                <div class="cell-40">
                    <p class="fx-n2 text-muted"><?=nl2br(htmlentities($res->contents))?></p>
                </div>
                <div class="cell-15">
                    <span><?=$res->user_name?></span>
                    <small class="text-muted">(<?=$res->user_id?>)</small>
                </div>
                <div class="cell-15">
                    <span class="text-muted fx-n1"><?=$res->start_date?></span>
                </div>
                <div class="cell-10">
                    <span><?=number_format($res->price)?></span>
                    <small class="text-muted">원</small>
                </div>
                <div class="cell-10">
                    -
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<?php endif;?>
<!-- /보낸 목록 -->

<!-- 요청 폼 -->
<div id="request-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/requests" class="modal-content" method="post">
            <div class="modal-body px-4 pt-4">
                <div class="title text-center">
                    REQUEST
                </div>
                <div class="mt-4 form-group">
                    <label for="start_date">시공일</label>
                    <input type="date" id="start_date" class="form-control" name="start_date" required>
                </div>
                <div class="form-group">
                    <textarea name="contents" id="contents" cols="30" rows="10" placeholder="원하는 시공 내용을 상세히 기술해 주세요!" class="form-control" required></textarea>
                </div>
                <div class="mt-4 form-group">
                    <button class="w-100 py-3 text-white bg-gold hover-opacity">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /요청 폼 -->

<!-- 응답 폼 -->
<div id="response-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/responses" class="modal-content" method="post">
            <input type="hidden" id="qid" name="qid">
            <div class="modal-body px-4 pt-4">
                <div class="title text-center">
                    RESPONSE
                </div>
                <div class="mt-4 form-group">
                    <label for="price">비용</label>
                    <input type="number" id="price" class="form-control" name="price" min="1" value="10000" required>
                </div>
                <div class="mt-4 form-group">
                    <button class="w-100 py-3 text-white bg-gold hover-opacity">입력 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $("[data-target='#response-modal']").on("click", e => {
            $("#qid").val(e.target.dataset.id);
        });
    });
</script>
<!-- /응답 폼 -->

<!-- 보기 폼 -->
<div id="view-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/estimates/pick" class="modal-content" method="post">
            <input type="hidden" id="pick_qid" name="qid">
            <input type="hidden" id="pick_sid" name="sid">
            <div class="modal-body px-4 pt-4">
                <div class="title text-center">
                    ESTIMATE
                </div>
                <div class="table-head mt-4">
                    <div class="cell-30">전문가 정보</div>
                    <div class="cell-40">비용</div>
                    <div class="cell-30">+</div>
                </div>
                <div class="list">
                    
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $("#view-modal .list").on("click", "button", e => {
        $("#pick_sid").val(e.target.dataset.id);
    });

    $("[data-target='#view-modal']").on("click", e => {
        $("#pick_qid").val(e.target.dataset.id);
        
        $.getJSON("/responses?id="+e.target.dataset.id, res => {
            if(res) {
                $("#view-modal .list").html('');
                res.list.forEach(item => {
                    $("#view-modal .list").append(`<div class="table-item">
                        <div class="cell-30">
                            <span>${item.user_name}</span>
                            <small class="text-gold">(${item.user_id})</small>
                        </div>
                        <div class="cell-40">
                            <span>${parseInt(item.price).toLocaleString()}</span>
                            <small class="text-muted">원</small>
                        </div>
                        <div class="cell-30">
                            ${
                                res.request.sid ? '':
                                `<button class="px-3 py-1 bg-blue text-white fx-n2" data-id="${item.id}">선택</button>`
                            }
                        </div>
                    </div>`);
                });
            }
        });
    });
</script>
<!-- /보기 폼 -->