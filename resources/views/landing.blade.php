@extends('layout.app')
@section('content')
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Price</th>
            <th>IDR</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $product)
        <tr>
            <td>{{$product->id}}</td>
            <td>{{$product->name}}</td>
            <td>{{$product->price}}</td>
            <td>{{$product->price_idr}}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">Tidak ada produk</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection