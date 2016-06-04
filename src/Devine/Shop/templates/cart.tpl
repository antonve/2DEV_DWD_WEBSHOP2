<h1>Jouw Winkelmand</h1>
<div id="products-container" class="product-margin">
    {{if {$products|@count} == 0}}
    <p class="error">Geen producten in jouw winkelmand gevonden.</p>
    {{/if}}
    {{foreach $products as $product}}
    <div class="product hot-{{$product->getHot()}}">
        <h2>{{$product->getTitle()}} <span>HOT</span></h2>
        <img src="{{$rootDir}}/thumbs/{{$product->getThumb()}}.jpg" alt="{{$product->getTitle()}}" title="{{$product->getTitle()}}"  />
        <div class="product-description">
            <p>{{$product->getDescription()}}</p>
            <p>Categorie: {{$product->getCategory()}}</p>
            <span>&euro; {{$product->getPrice()}}</span>
            <form action="{{$root}}/cart/update/{{$product->getId()}}" method="post" class="update_form">
                <fieldset>
                    <input type="submit" value="Aanpassen" />
                    <input type="text" value="{{$cart[$product->getId()]}}" name="amount" />
                </fieldset>
            </form>
        </div>
    </div>
    {{/foreach}}
    <div class="clearfix"></div>
    <p id="total">Totaal: &euro; <span id="total-costs">{{$total}}</span></p>
</div>
