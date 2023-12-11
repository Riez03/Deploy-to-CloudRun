<?php

namespace App\Http\Controllers\API;

use App\Models\Ingredients;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class IngredientsController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $types = $request->input('types');

        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        $rate_from = $request->input('rate_from');
        $rate_to = $request->input('rate_to');

        if ($id) {
            $ingredients = Ingredients::find($id);

            if ($ingredients) {
                return ResponseFormatter::success(
                    $ingredients,
                    'Data produk berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ada',
                    404
                );
            }
        }

        $ingredients = Ingredients::Query();

        if ($name) {
            $ingredients->where('name', 'like', '%' . $name . '%');
        }

        if ($types) {
            $ingredients->where('types', 'like', '%' . $types . '%');
        }

        if ($price_from) {
            $ingredients->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $ingredients->where('price', '<=', $price_to);
        }

        if ($rate_from) {
            $ingredients->where('rate', '<=', $rate_from);
        }

        if ($rate_to) {
            $ingredients->where('rate', '<=', $rate_to);
        }

        return ResponseFormatter::success(
            $ingredients->paginate($limit),
            'Data list produk berhasil diambil'
        );
    }

    public function getByName($name)
    {
        $ingredients = Ingredients::where('name', 'like', '%' . $name . '%')->get();

        if ($ingredients->isNotEmpty()) {
            return ResponseFormatter::success(
                $ingredients,
                'Data Pencarian Berhasil Ditemukan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data tidak ditemukan',
                404
            );
        }
    }
}
