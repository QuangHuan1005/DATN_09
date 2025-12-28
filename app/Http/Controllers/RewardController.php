<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\UserVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    /**
     * Trang điểm thưởng + danh sách voucher đổi điểm
     */
    public function index()
    {
        $user = Auth::user();

        $vouchers = Voucher::where('status', 1)
            ->whereNotNull('points_required')
            ->where('points_required', '>', 0)
            ->where('quantity', '>', 0)
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            })
            ->orderBy('points_required')
            ->get();

        return view('account.reward-points', compact('user', 'vouchers'));
    }

    /**
     * Đổi điểm lấy voucher
     */
    public function exchange($voucherId)
    {
        $user = Auth::user();

        $voucher = Voucher::where('id', $voucherId)
            ->whereNotNull('points_required')
            ->where('points_required', '>', 0)
            ->where('status', 1)
            ->lockForUpdate()
            ->firstOrFail();

        // ❌ Không đủ điểm
        if ($user->points < $voucher->points_required) {
            return back()->with('error', 'Bạn không đủ điểm để đổi voucher này');
        }

        // ❌ Voucher hết
        if ($voucher->quantity <= 0) {
            return back()->with('error', 'Voucher đã hết lượt');
        }

        // ❌ Đã đổi voucher này rồi
        $existed = UserVoucher::where('user_id', $user->id)
            ->where('voucher_id', $voucher->id)
            ->exists();

        if ($existed) {
            return back()->with('error', 'Bạn đã đổi voucher này rồi');
        }

        DB::transaction(function () use ($user, $voucher) {

            // Trừ điểm
            $user->decrement('points', $voucher->points_required);

            // Lưu voucher cho user
            UserVoucher::create([
                'user_id'    => $user->id,
                'voucher_id' => $voucher->id,
                'is_used'    => 0,
            ]);

            // Giảm số lượng voucher
            $voucher->decrement('quantity');
        });

        return back()->with('success', '🎉 Đổi voucher thành công!');
    }
}
