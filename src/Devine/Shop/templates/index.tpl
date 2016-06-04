<div id="home">
    <h1>Laatste nieuwe producten</h1>
    <div id="latest-releases" class="product-margin">
        {{foreach $latest_products as $product}}
        {{include file="product.tpl"}}
        {{/foreach}}
        <div class="clearfix"></div>
    </div>
    <h1>Populaire producten</h1>
    <div id="popular-products" class="product-margin">
        {{foreach $hot_products as $product}}
        {{include file="product.tpl"}}
        {{/foreach}}
    </div>
</div>
