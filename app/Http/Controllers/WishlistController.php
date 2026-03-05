<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with(['product', 'vehicle'])
            ->where(function ($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', Session::getId());
                }
            })->latest()->get();

        return view('pages.wishlist', compact('wishlists'));
    }

    public function toggle(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $userId = Auth::id();
        $sessionId = Session::getId();

        $wishlist = Wishlist::where('product_id', $product->id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Berhasil dihapus dari wishlist';
        } else {
            Wishlist::create([
                'product_id' => $product->id,
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
            ]);
            $status = 'added';
            $message = 'Berhasil ditambahkan ke wishlist';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => Wishlist::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })->count()
            ]);
        }

        return back()->with('success', $message);
    }

    public function toggleVehicle(Request $request, $vehicleId)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        $userId = Auth::id();
        $sessionId = Session::getId();

        $wishlist = Wishlist::where('vehicle_id', $vehicle->id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Berhasil dihapus dari wishlist';
        } else {
            Wishlist::create([
                'vehicle_id' => $vehicle->id,
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
            ]);
            $status = 'added';
            $message = 'Berhasil ditambahkan ke wishlist';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => Wishlist::where(function ($query) use ($userId, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('session_id', $sessionId);
                    }
                })->count()
            ]);
        }

        return back()->with('success', $message);
    }
}
