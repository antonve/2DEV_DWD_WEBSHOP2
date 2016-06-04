<div class="product hot-{{$product->getHot()}}">
    <h2>{{$product->getTitle()}} <span>HOT</span></h2>
    <img src="{{$rootDir}}/thumbs/{{$product->getThumb()}}.jpg" alt="{{$product->getTitle()}}" title="{{$product->getTitle()}}"  />
    <div class="product-description">
        <p>{{$product->getDescription()}}</p>
        <p>Categorie: {{$product->getCategory()}}</p>
        <span>&euro; {{$product->getPrice()}}</span>
        {{if !array_key_exists($product->getId(), $cart)}}
        <a href="{{$root}}/cart/add/{{$product->getId()}}" class="add-cart">Toevoegen &raquo;</a>
        {{else}}
        <a href="{{$root}}/cart/remove/{{$product->getId()}}" class="remove-cart">Verwijderen &raquo;</a>
        {{/if}}
    </div>
</div>
