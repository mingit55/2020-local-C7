class Product {
    butCount = 0;

    constructor(app, json){
        json.price = parseInt(json.price.replace(/[^0-9]/, ''));
        this.json = json;
        this.init();

        this.app = app;
    }
    
    get totalPrice(){
        return this.buyCount * this.json.price;
    }

    init(){
        const {id, product_name, brand, photo, price} = this.json;
        this.id = id;
        this.product_name = product_name;
        this.brand = brand;
        this.photo = photo;
        this.price = price;
        return this;
    }
    
    storeUpdate(){
        const {id, photo, price} = this.json;       
        const {product_name, brand} = this;       

        if(this.$storeElem == null){
            this.$storeElem = $(`<div class="col-lg-4 col-md-6 mb-5">
                                    <div class="store-item">
                                        <div class="image overflow-hidden rounded" style="height: 200px;" data-id="${id}" draggable="draggable">
                                            <img class="fit-cover" src="./resources/images/products/${photo}" alt="상품 이미지">
                                        </div>
                                        <div class="mt-4 px-3 d-between align-items-end">
                                            <div class="w-50">
                                                <div class="brand text-ellipsis text-muted fx-n2">${brand}</div>
                                                <div class="product_name text-blue text-ellipsis">${product_name}</div>
                                            </div>
                                            <div class="w-50 text-right text-ellipsis">
                                                <strong class="fx-2 text-blue">${price.toLocaleString()}</strong>
                                                <small class="text-muted">원</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>`);
        } else {
            this.$storeElem.find(".product_name").html(product_name);
            this.$storeElem.find(".brand").html(brand);
        }
    }

    cartUpdate(){
        const {id, product_name, brand, photo, price} = this.json;

        if(this.$cartElem == null){
            this.$cartElem = $(`<div class="table-item">
                                    <div class="cell-50">
                                        <div class="d-flex">
                                            <img width="80" height="80" src="./resources/images/products/${photo}" alt="상품 이미지">
                                            <div class="text-left my-3 ml-4">
                                                <div class="fx-n2 text-muted">${brand}</div>
                                                <div class="fx-2">${product_name}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cell-15">
                                        <span class="price text-muted">${price.toLocaleString()}</span>
                                        <small class="text-muted">원</small>
                                    </div>
                                    <div class="cell-10">
                                        <input type="number" class="buy-count" min="1" value="${this.buyCount}" data-id="${id}">
                                    </div>
                                    <div class="cell-15">
                                        <span class="total text-gold">${this.totalPrice.toLocaleString()}</span>
                                        <small class="text-muted">원</small>
                                    </div>
                                    <div class="cell-10">
                                        <button class="remove text-muted" data-id="${id}">×</button>
                                    </div>
                                </div>`);           
        } else {
            this.$cartElem.find(".buy-count").val(this.buyCount);
            this.$cartElem.find(".total").text(this.totalPrice.toLocaleString());
        }
    }
}