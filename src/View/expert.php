<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px">
    <div class="design-line"></div>
    <div class="design-line"></div>
    <div class="images">
        <img src="./resources/images/slides/1.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    </div>
    <div class="position-center text-center">
        <div class="text-white fx-7 segoe font-weight-bolder">EXPERTS</div>
        <div class="fx-1 text-gray">당신의 꿈을 현실로 이뤄줄 전문가들이 모였습니다</div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 전문가 영역 -->
<div class="padding">
    <div class="text-center text-center pb-5">
        <span class="text-muted">전문가 소개</span>
        <div class="title blue">EXPERTS</div>
    </div>
    <div class="bg-blue my-4 position-relative">
        <div class="container">
            <div class="row">
                <?php foreach($experts as $expert):?>
                <div class="expert-item col-lg-3 col-6 mb-4 mb-lg-0">
                    <div class="inner">
                        <div class="front">
                            <img class="fit-cover" src="/uploads/users/<?=$expert->photo?>" alt="전문가 이미지" title="전문가 이미지">
                        </div>
                        <div class="back bg-white px-3 py-5 d-flex flex-column-reverse">
                            <div class="d-flex flex-column align-items-center">
                                <div class="fx-2"><?=$expert->user_name?></div>
                                <div class="fx-n2 text-gold">(<?=$expert->user_id?>)</div>
                                <div class="my-3 text-gold">
                                    <?php for($i = 0; $i < $expert->score ; $i++):?>
                                        <i class="fa fa-star"></i>
                                    <?php endfor;?>
                                    <?php for(; $i < 5; $i++):?>
                                        <i class="fa fa-star-o"></i>
                                    <?php endfor;?>
                                </div>
                                <hr style="width: 50px;">
                                <button class="hover-opacity bg-gold text-white fx-n2 px-4 py-2" data-target="#write-modal" data-toggle="modal" data-id="<?=$expert->id?>">시공 후기 작성</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<!-- /전문가 영역 -->

<!-- 리뷰 영역 -->
<div class="bg-gray">
    <div class="container padding">
        <div class="sticky-top pt-4 bg-gray">
            <span class="text-muted">전문가 리뷰</span>
            <div class="title">REVIEWS</div>
            <div class="table-head mt-4">
                <div class="cell-15">전문가 정보</div>
                <div class="cell-40">내용</div>
                <div class="cell-15">작성자</div>
                <div class="cell-15">비용</div>
                <div class="cell-15">평점</div>
            </div>
        </div>
        <div class="list">
            <?php foreach($reviews as $review):?>
            <div class="table-item">
                <div class="cell-15">
                    <span><?=$review->e_name?></span>
                    <small class="text-blue">(<?=$review->e_id?>)</small>
                </div>
                <div class="cell-40">
                    <p class="fx-n2 text-muted"><?=nl2br(htmlentities($review->contents))?></p>
                </div>
                <div class="cell-15">
                    <span><?=$review->user_name?></span>
                    <small class="text-muted">(<?=$review->user_id?>)</small>
                </div>
                <div class="cell-15">
                    <span><?=number_format($review->price)?></span>
                    <small class="text-muted">원</small>
                </div>
                <div class="cell-15">
                    <div class="text-gold">
                        <?php for($i = 0; $i < $review->score ; $i++):?>
                            <i class="fa fa-star"></i>
                        <?php endfor;?>
                        <?php for(; $i < 5; $i++):?>
                            <i class="fa fa-star-o"></i>
                        <?php endfor;?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!-- /리뷰 영역 -->


<!-- 리뷰 작성  -->
<div id="write-modal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/experts/reviews" class="modal-content" method="post">
            <input type="hidden" id="eid" name="eid">
            <div class="modal-body px-4 pt-4">
                <div class="title text-center">
                    REVIEW
                </div>
                <div class="mt-4 form-group">
                    <label for="price">비용</label>
                    <input type="number" id="price" class="form-control" name="price" min="1" value="10000" required>
                </div>
                <div class="form-group">
                    <label for="score">평점</label>
                    <select name="score" id="score" class="form-control" required>
                        <option value="1">1점</option>
                        <option value="2">2점</option>
                        <option value="3">3점</option>
                        <option value="4">4점</option>
                        <option value="5">5점</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="contents" id="contents" cols="30" rows="10" placeholder="전문가에 대한 상세한 후기를 남겨보세요!" class="form-control" required></textarea>
                </div>
                <div class="mt-4 form-group">
                    <button class="w-100 py-3 text-white bg-gold hover-opacity">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $("[data-target='#write-modal']").on("click", e => {
            $("#eid").val(e.target.dataset.id);
        }); 
    });
</script>
<!-- /리뷰 작성  -->