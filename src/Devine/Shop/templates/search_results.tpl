<div id="products">
    <h1>Gevonden producten</h1>
    <div id="products-container" class="product-margin">
        {{if {$products|@count} == 0}}
        <p class="error">Geen producten gevonden.</p>
        {{/if}}
        {{foreach $products as $product}}
        {{include file="product.tpl"}}
        {{/foreach}}
        <div class="clearfix"></div>
    </div>
</div>
