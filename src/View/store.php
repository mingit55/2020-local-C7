<!-- 비주얼 영역 -->
<div id="visual" style="height: 400px">
        <div class="design-line"></div>
        <div class="design-line"></div>
        <div class="images">
            <img src="./resources/images/slides/3.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
        </div>
        <div class="position-center text-center">
            <div class="text-white fx-7 segoe font-weight-bolder">STORE</div>
            <div class="fx-1 text-gray">다양한 인테리어로 당신의 공간을 채워보세요</div>
        </div>
    </div>
    <!-- /비주얼 영역 -->

    <!-- 장바구니 영역 -->
    <div class="container padding">
        <div class="sticky-top pt-4 bg-white">
            <div>
                <span class="text-muted">장바구니</span>
                <div class="title">CART</div>
            </div>
            <div class="table-head">
                <div class="cell-50">상품 정보</div>
                <div class="cell-15">가격</div>
                <div class="cell-10">수량</div>
                <div class="cell-15">합계</div>
                <div class="cell-10">+</div>
            </div>
        </div>
        <div id="cart-list">
            <div class="w-100 py-5 text-center fx-n2 text-muted">장바구니에 올라간 상품이 없습니다.</div>
        </div>
        <div class="mt-3 d-between">
            <div>
                <span class="text-muted">총 가격</span>
                <span class="ml-3 text-gold fx-3 total-price">0</span>
                <small class="text-muted">원</small>
            </div>
            <button class="button-label bg-gold" data-toggle="modal" data-target="#buy-modal">구매하기</button>
        </div>
    </div>
    <!-- /장바구니 영역 -->
    <!-- 스토어 영역 -->
    <div class="bg-gray">
        <div class="container padding">
            <div class="sticky-top border-bottom pb-3 pt-4 d-between align-items-end bg-gray">
                <div>
                    <span class="text-muted">인테리어 스토어</span>
                    <div class="title blue">STORE</div>
                </div>
                <div class="d-align-center">
                    <input type="checkbox" id="open-cart" hidden checked>
                    <div class="search">
                        <span class="icon"><i class="fa fa-search"></i></span>
                        <input type="text" placeholder="검색어를 입력하세요">
                    </div>
                    <label for="open-cart" class="ml-4 mr-5 text-blue">
                        <i class="fa fa-shopping-cart fa-lg"></i>
                    </label>
                    <div id="drop-area">
                        <div class="text-center text-white">
                            <div class="success position-center">
                                <i class="fa fa-3x fa-check"></i>
                                <p class="mt-4 text-nowrap fx-n2">장바구니에 담았습니다!</p>
                            </div>
                            <div class="error position-center">
                                <i class="fa fa-3x fa-times"></i>
                                <p class="mt-4 text-nowrap fx-n2">이미 장바구니에 담긴 상품입니다.</p>
                            </div>
                            <div class="normal position-center">
                                <i class="fa fa-3x fa-shopping-cart"></i>
                                <p class="mt-4 text-nowrap fx-n2">이곳에 상품을 넣어주세요.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="store-list" class="row mt-4">
                <div class="w-100 py-5 text-center fx-n2 text-muted">일치하는 상품이 없습니다.</div>         
            </div>
        </div>
    </div>
    <!-- /스토어 영역 -->
    
    <!-- 구매 모달 -->
    <div id="buy-modal" class="modal fade">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-body px-4 py-5">
                    <div class="title text-center">
                        BUY ITEM
                    </div>
                    <div class="mt-4 form-group">
                        <label for="user_name">구매자</label>
                        <input type="text" id="user_name" class="form-control" placeholder="이름을 입력하세요" required>
                    </div>
                    <div class="form-group">
                        <label for="address">배송지</label>
                        <input type="text" id="address" class="form-control" placeholder="주소를 입력하세요" required>
                    </div>
                    <div class="form-group mt-3">
                        <button class="w-100 py-3 bg-gold text-white hover-opacity">구매 완료</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /구매 모달 -->

    <!-- 구매 내역 모달 -->
    <div id="result-modal" class="modal fade">
        <div class="modal-dialog"></div>
        <img alt="구매 내역" class="mw-100 mx-3 position-center">
    </div>
    <!-- /구매 내역 모달 -->
    
    <script src="./resources/js/Store.js"></script>
    <script src="./resources/js/Product.js"></script>