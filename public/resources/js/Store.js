class Store {
    keyword = "";
    cartList = [];
    $cartList = $("#cart-list");
    $storeList = $("#store-list");
    $dropArea = $("#drop-area");

    constructor(){
        this.init();
        this.setEvents();
    }
    
    async init(){
        this.products = await this.getProducts();

        this.cartUpdate();
        this.storeUpdate();
    }

    get totalPrice(){
        return this.cartList.reduce((p, c) => p + c.totalPrice, 0);
    }

    getProducts(){
        return fetch("/resources/store.json")
            .then(res=> res.json())
            .then(jsonList => jsonList.map(json => new Product(this, json)));
    }

    storeUpdate(){
        let viewList = this.products.map(item => item.init());
        
        if(this.keyword !== ""){
            let regex = new RegExp(this.keyword, "g");
            viewList = viewList.filter(item => regex.test(item.json.product_name) || regex.test(item.json.brand))
                .map(item => {
                    item.product_name = item.json.product_name.replace(regex, m1 => `<span class='bg-gold'>${m1}</span>`);
                    item.brand = item.json.brand.replace(regex, m1 => `<span class='bg-gold'>${m1}</span>`);
                    return item;
                });
        }

        if(viewList.length > 0){
            this.$storeList.html('');            
            viewList.forEach(item => {
                item.storeUpdate();
                this.$storeList.append(item.$storeElem);
            });
        } else {
            this.$storeList.html(`<div class="w-100 py-5 text-center fx-n2 text-muted">일치하는 상품이 없습니다.</div>`);
        }
    }

    cartUpdate(){
        if(this.cartList.length > 0){
            this.$cartList.html('');
            this.cartList.forEach(item => {
                item.cartUpdate()                
                this.$cartList.append(item.$cartElem);
            });
        } else {
            this.$cartList.html(`<div class="w-100 py-5 text-center fx-n2 text-muted">장바구니에 올라간 상품이 없습니다.</div>`);           
        }

        $(".total-price").text(this.totalPrice.toLocaleString());
    }

    setEvents(){
        // 상품 추가
        let dragTarget, startPoint;
        this.$storeList.on("dragstart", ".image", e => {
            e.preventDefault();

            dragTarget = e.currentTarget;
            startPoint = [e.pageX, e.pageY];
            dragTarget.style.transition = "none";
            dragTarget.style.zIndex = "1200";
            dragTarget.style.position = "relative";
        });

        $(window).on("mousemove", e => {
            if(!dragTarget || !startPoint || e.which !== 1) return;

            dragTarget.style.left = e.pageX - startPoint[0] + "px";
            dragTarget.style.top = e.pageY - startPoint[1] + "px";
        }); 

        let timeout;
        $(window).on("mouseup", e => {
            if(!dragTarget || !startPoint || e.which !== 1) return;

            let {left, top} = this.$dropArea.offset();
            let width = this.$dropArea.width();
            let height = this.$dropArea.height();

            // 드롭 영역 안에 드롭 될 떄
            if(left <= e.pageX && e.pageX <= left + width && top <= e.pageY && e.pageY <= top + height){
                if(timeout){
                    clearTimeout(timeout);
                }
                this.$dropArea.removeClass("success");
                this.$dropArea.removeClass("error");

                let target = dragTarget;

                let product = this.products.find(item => item.id == target.dataset.id);

                if(this.cartList.some(item => item == product)){
                    this.$dropArea.addClass("error");
                    $(target).animate({
                        left: 0,
                        top: 0
                    }, 350, function(){
                        this.style.zIndex = "0";
                    });    
                } else {
                    this.$dropArea.addClass("success");

                    product.buyCount = 1;
                    this.cartList.push(product);
                    this.cartUpdate();

                    $(target).css({
                        transition: "transform 0.5s",
                        transform: "scale(0)"
                    });
                    setTimeout(() => {
                        $(target).css({
                            zIndex: "0",
                            left: "0",
                            top: "0",
                            transform: "scale(1)"
                        });
                    }, 500);
                }

                timeout = setTimeout(() => {
                    this.$dropArea.removeClass("error");
                    this.$dropArea.removeClass("success");
                }, 1500);

            } else {
                $(dragTarget).animate({
                    left: 0,
                    top: 0
                }, 350, function(){
                    this.style.zIndex = "0";
                });
            }

            dragTarget = null;
            startPoint = null;
        });

        // 상품 수정
        this.$cartList.on("input", ".buy-count", e => {
            let value = parseInt(e.target.value);

            if(isNaN(value) || !value || value < 1){
                value = 1;
            }

            let product = this.cartList.find(item => item.id == e.target.dataset.id);
            product.buyCount = value;
            this.cartUpdate();

            e.target.focus();
        });

        // 상품 삭제
        this.$cartList.on("click", ".remove", e => {
            let idx = this.cartList.findIndex(item => item.id == e.currentTarget.dataset.id); 
            if(idx >= 0){
                let product = this.cartList[idx];
                product.buyCount = 0;
                this.cartList.splice(idx, 1);
                this.cartUpdate();     
            }
        });


        // 구매하기
        $("#buy-modal form").on("submit", e => {
            e.preventDefault();
            
            const PADDING = 30;
            const TXT_SIZE = 18;
            const TXT_GAP = 20;

            let canvas = document.createElement("canvas");
            let ctx = canvas.getContext("2d");
            ctx.font = `${TXT_SIZE}px '나눔스퀘어', sans-serif`;
            
            let now = new Date();
            let time_txt = `구매일시            ${now.getFullYear()}-${now.getMonth() + 1}-${now.getDate()} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;
            let price_txt = `총 합계            ${this.totalPrice.toLocaleString()}원`;

            let viewList = [
                ...this.cartList.map(item => {
                    let text = `${item.product_name}            ${item.price.toLocaleString()}원 × ${item.buyCount.toLocaleString()}개 = ${(item.price * item.buyCount).toLocaleString()}원`;
                    let width = ctx.measureText(text).width;
                    return {text, width};
                }),
                {text: time_txt, width: ctx.measureText(time_txt).width},
                {text: price_txt, width: ctx.measureText(price_txt).width}
            ];

            let max_w = viewList.reduce((p, c) => Math.max(p, c.width), viewList[0].width);

            canvas.width = max_w + PADDING * 2;
            canvas.height = (TXT_SIZE + TXT_GAP) * viewList.length + PADDING * 2;

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#fff";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.fillStyle = "#333";
            ctx.font = `${TXT_SIZE}px '나눔스퀘어', sans-serif`;

            viewList.forEach(({text}, i) => {
                ctx.fillText(text, PADDING, PADDING + TXT_GAP * i + TXT_SIZE * (i + 1));
            });

            let url = canvas.toDataURL('image/jpeg');
            $("#result-modal img").attr("src", url);
            $("#result-modal").modal('show');
            $("#buy-modal").modal('hide');
            $("#buy-modal input").val('');

            this.cartList.forEach(item => item.buyCount = 0);
            this.cartList = [];
            this.cartUpdate();
        });

        // 검색
        $(".search input").on("input", e => {
            this.keyword = e.target.value
                .replace(/[\.*+?^$\[\]\(\)\\\\\\/]/g, "\\$1")
                .replace(/(ㄱ)/g, "[가-깋]")
                .replace(/(ㄴ)/g, "[나-닣]")
                .replace(/(ㄷ)/g, "[다-딯]")
                .replace(/(ㄹ)/g, "[라-맇]")
                .replace(/(ㅁ)/g, "[마-밓]")
                .replace(/(ㅂ)/g, "[바-빟]")
                .replace(/(ㅅ)/g, "[사-싷]")
                .replace(/(ㅇ)/g, "[아-잏]")
                .replace(/(ㅈ)/g, "[자-짛]")
                .replace(/(ㅊ)/g, "[차-칳]")
                .replace(/(ㅋ)/g, "[카-킿]")
                .replace(/(ㅌ)/g, "[타-팋]")
                .replace(/(ㅍ)/g, "[파-핗]")
                .replace(/(ㅎ)/g, "[하-힣]");
            this.storeUpdate();
        });
    }
}

$(function(){
    window.store = new Store();
});