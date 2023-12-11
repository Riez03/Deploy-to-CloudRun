<?php

namespace App\Http\Controllers\API;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $ingredients_id = $request->input('ingredients_id');

        if ($id) {
            $wishlist = Wishlist::with('ingredients', 'user')->find($id);

            if ($wishlist) {
                return ResponseFormatter::success(
                    $wishlist,
                    'Data transaksi berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data transaksi tidak ada',
                    404
                );
            }
        }

        $wishlist = Wishlist::with('ingredients', 'user')
            ->where('user_id', Auth::user()->id);

        if ($ingredients_id) {
            $wishlist->where('ingredients_id', $ingredients_id);
        }

        return ResponseFormatter::success(
            $wishlist->paginate($limit),
            'Data list transaksi berhasil diambil'
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'ingredients_id' => 'required|exists:ingredients,id',
        ]);

        $user = Auth::user();

        // Cek apakah item sudah ada di Wishlist
        $existingWishlist = Wishlist::where('user_id', $user->id)
            ->where('ingredients_id', $request->ingredients_id)
            ->first();

        if ($existingWishlist) {
            return ResponseFormatter::error(
                null,
                'Item sudah ada di Wishlist',
                422
            );
        }

        // Tambahkan item baru ke Wishlist
        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'ingredients_id' => $request->ingredients_id,
        ]);

        return ResponseFormatter::success(
            $wishlist,
            'Item berhasil ditambahkan ke Wishlist'
        );
    }
}
