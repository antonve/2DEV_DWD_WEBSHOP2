<div id="products">
    <h1>Filter</h1>
    <form id="filter_form" action="{{$root}}/products/filter" method="post">
        <fieldset id="products-filter" class="filter-{{$filter}}">
            <legend>Filter</legend>
            <label for="products_filter_category">Categorie</label>
            <select name="products_filter[category]" id="products_filter_category" title="{{if isset($category)}}{{$category}}{{/if}}">
                <option value="all">Alles</option>
                {{foreach $categories as $cat}}
                <option value="{{$cat}}">{{$cat}}</option>
                {{/foreach}}
            </select>
            <label for="products_filter_type">Type</label>
            <select name="products_filter[type]" id="products_filter_type" title="{{if isset($type)}}{{$type}}{{/if}}">
                <option value="all">Alles</option>
                {{foreach $types as $type}}
                <option value="{{$type}}">{{$type}}</option>
                {{/foreach}}
            </select>
            <input type="submit" value="Toepassen"/>
        {{if $filter == "true"}}
        <a href="{{$root}}/products" id="cancel-filter">Annuleren</a>
        {{/if}}
        </fieldset>
    </form>
    <h1>Producten</h1>
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
