<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px">
    <div class="design-line"></div>
    <div class="design-line"></div>
    <div class="images">
        <img src="./resources/images/slides/2.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    </div>
    <div class="position-center text-center">
        <div class="text-white fx-7 segoe font-weight-bolder">PARTY</div>
        <div class="fx-1 text-gray">나만의 인테리어 노하우를 모두에게 알려보세요</div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 온라인 집들이 -->
<div class="container padding">
    <div class="d-between border-bottom align-items-end">
        <div class="pb-3">
            <span class="text-muted">온라인 집들이</span>
            <div class="title">KNOWHOWS</div>
        </div>
        <button class="button-label" data-target="#write-modal" data-toggle="modal">
            글쓰기
            <i class="fa fa-pencil ml-3"></i>
        </button>
    </div>
    <div class="row mt-4">
        <?php foreach($knowhows as $knowhow):?>
        <div class="col-lg-4 col-md-6 mb-5">
            <div class="knowhow-item border">
                <div class="images">
                    <img class="fit-cover" src="/uploads/knowhows/<?=$knowhow->before_img?>" alt="Before 이미지" title="Before 이미지">
                    <img class="fit-cover" src="/uploads/knowhows/<?=$knowhow->after_img?>" alt="After 이미지" title="After 이미지">
                </div>
                <div class="px-3 py-3">
                    <div class="d-between">
                        <div>
                            <span><?=$knowhow->user_name?></span>
                            <small class="text-muted">(<?=$knowhow->user_id?>)</small>
                            <small class="text-muted ml-2"><?=date("Y-m-d", strtotime($knowhow->created_at))?></small>
                        </div>
                        <div class="text-gold score">
                            <i class="fa fa-star<?= $knowhow->score == 0 ? '-o' : '' ?>"></i>
                            <span><?=$knowhow->score?></span>
                        </div>
                    </div>
                    <div class="mt-3 fx-n2 text-muted">
                        <?=nl2br(htmlentities($knowhow->contents))?>
                    </div>
                    <?php if(!$knowhow->reviewed && $knowhow->uid != user()->id ):?>
                    <div class="open-modal mt-3 d-between">
                        <small class="text-muted">이 게시글이 마음에 드시나요?</small>
                        <button class="px-2 py-2 bg-gold text-white hover-opacity fx-n2" data-target="#score-modal" data-toggle="modal" data-id="<?=$knowhow->id?>">평점 주기</button>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!-- /온라인 집들이 -->

 <!-- 글쓰기 모달 -->
<div id="write-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/knowhows" class="modal-content" method="post" enctype="multipart/form-data">
            <div class="modal-body px-4 pt-4">
                <div class="title text-center">
                    KNOWHOW
                </div>
                <div class="mt-4 form-group">
                    <label for="before_img">Before 사진</label>
                    <div class="custom-file">
                        <input type="file" id="before_img" class="custom-file-input" name="before_img" required>
                        <label for="before_img" class="custom-file-label">파일을 업로드 하세요</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="after_img">After 사진</label>
                    <div class="custom-file">
                        <input type="file" id="after_img" class="custom-file-input" name="after_img" required>
                        <label for="after_img" class="custom-file-label">파일을 업로드 하세요</label>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="contents" id="contents" cols="30" rows="10" placeholder="나만의 노하우를 작성해 보세요!" class="form-control" required></textarea>
                </div>
                <div class="mt-4 form-group">
                    <button class="w-100 py-3 text-white bg-gold hover-opacity">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /글쓰기 모달 -->

<!-- 평점주기 모달 -->
<div id="score-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body py-5 text-center">
                <div class="text-muted">이 게시글의 평점을 매겨주세요</div>
                <div class="d-flex justify-content-center mt-3">
                    <button data-id="1" class="mx-2 border round text-gold px-3 py-2"><i class="fa fa-star mr-2"></i>1</button>
                    <button data-id="2" class="mx-2 border round text-gold px-3 py-2"><i class="fa fa-star mr-2"></i>2</button>
                    <button data-id="3" class="mx-2 border round text-gold px-3 py-2"><i class="fa fa-star mr-2"></i>3</button>
                    <button data-id="4" class="mx-2 border round text-gold px-3 py-2"><i class="fa fa-star mr-2"></i>4</button>
                    <button data-id="5" class="mx-2 border round text-gold px-3 py-2"><i class="fa fa-star mr-2"></i>5</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        let kid, score, $target;
        $("[data-target='#score-modal']").on("click", e => {
            kid = e.target.dataset.id;
            $target = $(e.target).closest(".knowhow-item");
        });

        $("#score-modal button").on("click", e => {
            score = e.currentTarget.dataset.id;
            
            $.post("/knowhows/reviews", {kid, score}, res => {
                if(res.score !== null){
                    if(res.score > 0){
                        $target.find(".score").html(`<i class="fa fa-star"></i><span>${score}</span>`);
                    } else {
                        $target.find(".score").html(`<i class="fa fa-star-o"></i><span>${score}</span>`);
                    }
                    $target.find(".open-modal").remove();
                    $("#score-modal").modal('hide');
                    kid = score = $target = null;
                }
            });
        });
    });
</script>
<!-- /평점주기 모달 -->