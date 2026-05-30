@foreach($products as $product)

<div class="col-lg-3 col-md-4 col-6 mb-4">

<div class="single-product">

<div class="product-img">

@php
$photo=explode(',',$product->photo);
@endphp

<img src="{{$photo[0]}}">

</div>

<div class="product-content">
<h3>{{$product->title}}</h3>

@php
$after_discount=($product->price-($product->price*$product->discount)/100);
@endphp

<span>₹{{$after_discount}}</span>

</div>

</div>

</div>

@endforeach