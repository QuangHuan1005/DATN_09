<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBankAccount;

class BankAccountController extends Controller
{
    /**
     * Hiển thị danh sách tài khoản ngân hàng
     */
    public function index()
    {
        $user = Auth::user();
        $bankAccounts = $user->bankAccounts()->orderBy('is_default', 'desc')->get();
        $maxAccounts = 5;
        $canAddMore = $bankAccounts->count() < $maxAccounts;

        return view('account.bank-accounts.index', compact('bankAccounts', 'maxAccounts', 'canAddMore'));
    }

    /**
     * Hiển thị form thêm tài khoản ngân hàng
     */
    public function create()
    {
        $user = Auth::user();

        // Kiểm tra giới hạn 5 tài khoản
        if ($user->bankAccounts()->count() >= 5) {
            return redirect()->route('account.bank-accounts.index')
                ->with('error', 'Bạn đã đạt giới hạn tối đa 5 tài khoản ngân hàng.');
        }

        // Lấy tên chủ tài khoản từ tài khoản ngân hàng đầu tiên (nếu đã có)
        $defaultAccountHolder = null;
        $firstBankAccount = $user->bankAccounts()->oldest('created_at')->first();
        if ($firstBankAccount) {
            $defaultAccountHolder = $firstBankAccount->account_holder;
        }

        return view('account.bank-accounts.create', compact('defaultAccountHolder'));
    }

    /**
     * Lưu tài khoản ngân hàng mới
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Kiểm tra giới hạn 5 tài khoản
        if ($user->bankAccounts()->count() >= 5) {
            return redirect()->back()
                ->with('error', 'Bạn chỉ có thể thêm tối đa 5 tài khoản ngân hàng.');
        }

        // Lấy tên chủ từ tài khoản đầu tiên (nếu có)
        $firstAccountHolder = $user->bankAccounts()->oldest('created_at')->value('account_holder');

        if ($firstAccountHolder) {
            // Nếu đã có tài khoản, tên chủ phải giống tài khoản đầu tiên
            if ($request->account_holder !== $firstAccountHolder) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['account_holder' => 'Tên chủ tài khoản phải giống với tài khoản ngân hàng đầu tiên của bạn.']);
            }
        } else {
            // Tài khoản đầu tiên - tên chủ do user nhập (sẽ được sử dụng cho các tài khoản sau)
            // Validation đảm bảo có tên chủ tài khoản
        }

        // Kiểm tra tài khoản trùng lặp (cùng tên ngân hàng + số tài khoản)
        $existingAccount = $user->bankAccounts()
            ->where('bank_name', $request->bank_name)
            ->where('account_number', $request->account_number)
            ->first();

        if ($existingAccount) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['duplicate' => 'Tài khoản ngân hàng này đã tồn tại trong danh sách của bạn.']);
        }

        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:100',
            'is_default' => 'boolean'
        ], [
            'bank_name.required' => 'Vui lòng nhập tên ngân hàng.',
            'bank_name.string' => 'Tên ngân hàng phải là chuỗi ký tự.',
            'bank_name.max' => 'Tên ngân hàng không được vượt quá 100 ký tự.',
            'account_number.required' => 'Vui lòng nhập số tài khoản.',
            'account_number.string' => 'Số tài khoản phải là chuỗi ký tự.',
            'account_number.max' => 'Số tài khoản không được vượt quá 50 ký tự.',
            'account_holder.required' => 'Tên chủ tài khoản là bắt buộc.',
            'account_holder.string' => 'Tên chủ tài khoản phải là chuỗi ký tự.',
            'account_holder.max' => 'Tên chủ tài khoản không được vượt quá 100 ký tự.',
            'is_default.boolean' => 'Trường mặc định phải là đúng hoặc sai.',
        ]);

        // Nếu đặt làm mặc định, bỏ mặc định của tài khoản khác
        if ($request->is_default) {
            $user->bankAccounts()->update(['is_default' => false]);
        }

        // Nếu chưa có tài khoản mặc định nào, đặt tài khoản này làm mặc định
        $hasDefault = $user->bankAccounts()->where('is_default', true)->exists();
        if (!$hasDefault) {
            $request->merge(['is_default' => true]);
        }

        UserBankAccount::create([
            'user_id' => $user->id,
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_holder' => $request->account_holder,
            'is_default' => $request->is_default ?? false
        ]);

        return redirect()->route('account.bank-accounts.index')
            ->with('success', 'Thêm tài khoản ngân hàng thành công!');
    }


    /**
     * Xóa tài khoản ngân hàng
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $bankAccount = $user->bankAccounts()->findOrFail($id);

        // Không cho xóa tài khoản mặc định nếu có nhiều hơn 1 tài khoản
        if ($bankAccount->is_default && $user->bankAccounts()->count() > 1) {
            return redirect()->back()
                ->with('error', 'Không thể xóa tài khoản mặc định. Vui lòng đặt tài khoản khác làm mặc định trước.');
        }

        $bankAccount->delete();

        // Nếu xóa tài khoản mặc định, đặt tài khoản khác làm mặc định
        if ($bankAccount->is_default) {
            $remainingAccount = $user->bankAccounts()->first();
            if ($remainingAccount) {
                $remainingAccount->update(['is_default' => true]);
            }
        }

        return redirect()->route('account.bank-accounts.index')
            ->with('success', 'Xóa tài khoản ngân hàng thành công!');
    }

    /**
     * Đặt tài khoản làm mặc định
     */
    public function setDefault($id)
    {
        $user = Auth::user();

        // Bỏ mặc định tất cả tài khoản
        $user->bankAccounts()->update(['is_default' => false]);

        // Đặt tài khoản này làm mặc định
        $bankAccount = $user->bankAccounts()->findOrFail($id);
        $bankAccount->update(['is_default' => true]);

        return redirect()->back()
            ->with('success', 'Đã đặt tài khoản mặc định thành công!');
    }
}
