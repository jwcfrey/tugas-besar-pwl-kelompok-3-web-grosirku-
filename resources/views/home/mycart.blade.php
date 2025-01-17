<!DOCTYPE html>
<html>

<head>
    @include('home.css')
    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 60px;
        }

        table {
            border: 2px solid black;
            text-align: center;
            width: 800px;
        }

        th {
            border: 2px solid black;
            text-align: center;
            color: white;
            font: 20px;
            font_weight: bold;
            background-color: black;
        }

        td {
            border: 2px solid skyblue;
        }

        .cart_value {
            text-align: center;
            margin-bottom: 70px;
            padding: 18px;
        }

        .order_deg {
            padding-right: 100px;
            margin-top: -50px;
        }

        label {
            display: inline-block;
            width: 150px;
        }

        .div_gap {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section starts -->
        @include('home.header')
        <!-- end header section -->
    </div>
    <div class="div_deg">
        <table>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Hapus</th>
            </tr>
            
            <?php $value = 0; ?>
            @foreach ($cart as $item)
            <tr>
                <td>{{ $item->product->title }}</td>
                <td>{{ $item->product->price }}</td>
                <td>
                    <img width="150" src="/products/{{ $item->product->image }}">
                </td>
                <td>
                    <form action="{{ url('delete_cart', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php $value += $item->product->price; ?>
            @endforeach
        </table>
    </div>
    <div class="cart_value">
        <h3>Jumlah total keranjang kamu sekarang adalah : Rp. {{ $value }}</h3>
    </div>
    <div class="order_deg" style="display: flex; justify-content: center; align-items: center;">
        <form action="{{ url('confirm_order') }}" method="POST">
            @csrf
            <div class="div_gap">
                <label for="">Nama Penerima</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}">
            </div>
            <div class="div_gap">
                <label for="">Alamat</label>
                <textarea name="address" id="">{{ Auth::user()->address }}</textarea>
            </div>
            <div class="div_gap">
                <label for="">Nomor HP</label>
                <input type="text" name="phone" value="{{ Auth::user()->phone }}">
            </div>
            <div class="div_gap">
                <input class="btn btn-primary" type="submit" value="Cash On Delivery">
                <a class="btn btn-success" href="{{ url('stripe', $value) }}">Payment Using Card</a>
            </div>
        </form>
    </div>
    <!-- info section -->
    @include('home.footer')
</body>

</html>
