<?php

namespace App\Traits;

use App\Jobs\SendMail;
use Illuminate\Support\Facades\Storage;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Shop\ForgotPasswordRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailContent;
use App\Models\Menu;
use App\Models\Product;

trait HelperTrait
{
    public static function deleteFile($object){
        if(!empty($object->thumb)){
            /* Thay thế string storage -> public để truy cập vào folder public/uploads-files bên server */
            $storagePath = str_replace('storage', 'public', $object->thumb);
            Storage::delete($storagePath); // Xóa ảnh trong server
            // Xóa ảnh trong client 
            $publicPath = public_path($object->thumb);
            unlink($publicPath);
        }
    }

    public static function sendMail($data){
        /* - Gửi email đi thông qua hàng đợi(Queue) để giảm tải khối lượng request, tách ra đặt hàng riêng, gửi mail 
        riêng(Không đồng bộ). Đây là cách hiệu quả để xử lý các tác vụ tốn thời gian mà không làm chậm trễ luồng xử 
        lý chính của ứng dụng.
        - dispatch() - Gửi đi: Việc dispatch job giúp xử lý công việc không đồng bộ, tức là thực hiện công việc mà không chặn 
        luồng xử lý chính của ứng dụng.
        - delay(): Đặt job này vào hàng đợi với một khoảng trễ 3 giây (Sau 3s mới thực hiện gửi mail đi)
        */
        #Queue
        // SendMail::dispatch($data)->delay(now()->addSeconds(3));

        Mail::to($data['email'])->send(new MailContent($data));
    }

    public static function validateAuthPassword($request, $table, $model){
        $forgotPwRequest = $model::createFrom($request);
        $forgotPwRequest->setTable($table);
        $forgotPwRequest->validate($forgotPwRequest->rules(), $forgotPwRequest->messages());
    }

    public static function applyForgotPasswordAction($model, $array){
        DB::beginTransaction();
        $token = Str::random(64);
        
        $model::create([
            'email' => $array['email'],
            'token' => $token
        ]);

        $data = [
            'title' => $array['title'],
            'email' => $array['email'],
            'token' => $token,
            'name' => $array['name'],
            'body' => $array['body'],
            'route' => $array['route'],
        ];

        self::sendMail($data);
        
        DB::commit();
        Session::flash('success', 'Gửi email thành công!');
    }

    public static function applyResetPasswordAction($data){
        DB::beginTransaction();
        $isValidUser = $data['modelResetPw']::where([
            'email' => $data['request']->email,
            'token' => $data['token'],
        ])->first();

        if($isValidUser){
            $user = $data['modelMain']::where('email', $data['request']->email)->first();
            $user->password = Hash::make($data['request']->new_password);
            $user->save();
            Auth::guard($data['guardName'])->login($user);

            /* Xóa hết những email quên mật khẩu của khách hàng trong bảng user_password_resets */
            $data['modelResetPw']::where('email', $data['request']->email)->delete();
            DB::commit();
            Session::flash('success', 'Đặt lại mật khẩu thành công');
            return true;
        }
        Session::flash('error', 'Token hoặc email không hợp lệ');
        return false;
        // return $data;
    }

    public static function getParents($model){
        // if($model == Permission::class || $model == Menu::class){
        //     return $model::whereNull('parent_id')->where('active', 1)->paginate(10);
        // }
        return $model::whereNull('parent_id')->where('active', 1)->get();
    }

    // public static function getParentWithChildren($model){
    //     return $model::with('childrenRecursive')->whereNull('parent_id')->where('active', 1)->paginate(2);
    // }

    public static function getMenus()
    {
        return Menu::where('active', '=', 1)->get();
    }

    public static function search($model, $search){
        $result = $model::where('id', '=', $search)
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->paginate(10);  
        return $result;
    }

    public static function getAll($request, $model){
        $result = $model::query();

        if($search = $request->search){
            $result->where('id', '=', $search)
                    ->orWhere('name', 'like', '%' . $search . '%'); 
        }

        if($filterParent = $request->query('filter-parent')){
            $result->where('id', '=', $filterParent)
                    ->orWhere('parent_id', '=', $filterParent);
        }

        /* Lọc sản phẩm */
        if($sortPrice = $request->query('sort-price')){
            $priceMin = $request->query('price-min');
            $priceMax = $request->query('price-max');
            $menuSlug = $request->query('menu');
            $startDate = $request->query('start-date');
            $endDate = $request->query('end-date');
            $result->join('menus as m', 'products.menu_id', '=', 'm.id')
                    ->select('products.*')
                    ->when(isset($menuSlug), function ($query) use ($menuSlug) {
                        $query->whereIn('m.slug', $menuSlug);
                    })
                    ->when(isset($priceMin) && isset($priceMax), function ($query) use ($priceMin, $priceMax) {
                        $query->whereBetween('products.price', [$priceMin, $priceMax]);
                    })
                    ->when(isset($startDate) && isset($endDate), function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('products.created_at', [$startDate, $endDate]);
                    })
                    ->when(isset($sortPrice), function ($query) use ($sortPrice) {
                        $query->orderBy('products.price', $sortPrice); 
                    });
        }

        // if($model == Permission::class || $model == Menu::class){
        //     return $result->whereNull('parent_id')->where('active', 1)->paginate(2);
        // }

        if($model == Permission::class || $model == Menu::class){
            return $result->with('childrenRecursive')->whereNull('parent_id')->where('active', 1)->paginate(2);
        }

        if($model == Product::class){
            return $result->orderBy('menu_id')->paginate(10);
        }
        
        return $result->paginate(10);  
    }

    public static function applyFilterEmptyQueryString($request, $route, $slug = ''){
        /* Lọc ra những query string ko rỗng */
        $filters = array_filter($request->query(), function ($value) {
            return !is_null($value) && $value != '';
        });

        $url = '';
        /* Trả về 1 url mới với các query string vừa lọc */
        if(!empty($slug)){
            $url = route($route, ['slug' => $slug]) . '?' . http_build_query($filters);
        }
        else{
            $url = route($route) . '?' . http_build_query($filters);
        }
    
        return redirect($url);
    }


}