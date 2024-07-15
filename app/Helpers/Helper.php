<?php
namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\Menu;

class Helper{

    public static function recursiveListMenu($menus, $route, $char = ''){
        $html = '';
        foreach ($menus as $key => $menu) {
            $html .= '
                <tr>
                    <td>'. $menu->id .'</td>
                    <td>
                        '.$char . $menu->name.'
                    </td>
                    <td>'. ($menu->parent()->exists() ? $menu->parent->name : '').'</td>
                    <td>'. $menu->description .'</td>
                    <td>
                        '.(isset($menu->thumb) ? '<a href='.$menu->thumb.' target="_blank"><img src='.$menu->thumb.' class="thumb-size-auto"></a> ' : '').'
                    </td>
                    <td>
                        '. (isset($menu->key_code) ? $menu->key_code : '') .'
                    </td>
                    <td>
                        '. (isset($menu->slug) ? $menu->slug : '') .'
                    </td>
                    <td>'. self::active($menu->active) .'</td>
                    <td>'. self::createdAtAndBy($menu) .'</td>
                    <td>'. self::updatedAtAndBy($menu) .'</td>
                    <td class="btn-group">
                        '. self::editRow($route, $menu) .'
                        '. self::deleteRow($route, $menu) .'
                    </td>
                </tr>
            ';

            /* - $menus[$key]: Trong TH này lấy ra đối tượng(menu) hiện tại
            - Loại bỏ mục menu vừa lặp qua, để tránh lặp lại menu đó khi đệ quy, dẫn tới chậm hiệu suất 
            web */
            unset($menus[$key]); 

            /* Sử dụng đệ quy để tìm các menu con của menu cha, gán cho dấu '--' để phân biệt: */ 
            if($menu->children()->exists()){
                $html .= self::recursiveListMenu($menu->children, $route, $char . '--');    
            }
        }
        return $html;
    }

    public static function selectList($menuParents, $route){
        $html = '';
        foreach ($menuParents as $mp) {
            $html .= '
                <tr>
                    <td>'. $mp->id .'</td>
                    <td>
                        <span class="badge badge-info">'.$mp->name.'</span>
                    </td>
                    <td>'. $mp->parent_id .'</td>
                    <td>'. $mp->description .'</td>
                    <td>
                        '.(isset($mp->thumb) ? '<a href='.$mp->thumb.' target="_blank"><img src='.$mp->thumb.' class="thumb-size-auto"></a> ' : '').'
                    </td>
                    <td>
                        '. (isset($mp->key_code) ? $mp->key_code : '') .'
                    </td>
                    <td>
                        '. (isset($mp->slug) ? $mp->slug : '') .'
                    </td>
                    <td>'. self::active($mp->active) .'</td>
                    <td>'. self::createdAtAndBy($mp) .'</td>
                    <td>'. self::updatedAtAndBy($mp) .'</td>
                    <td class="btn-group">
                        '. self::editRow($route, $mp) .'
                        '. self::deleteRow($route, $mp) .'
                    </td>
                </tr>
            ';
            foreach ($mp->children as $mc) {
                $html .= '
                    <tr>
                        <td>'. $mc->id .'</td>
                        <td>'. $mc->name .'</td>
                        <td>'. $mc->parent_id .'</td>
                        <td>'. $mc->description .'</td>
                        <td>
                            '.(isset($mc->thumb) ? '<a href='.$mc->thumb.' target="_blank"><img src='.$mc->thumb.' class="thumb-size-auto"></a> ' : '').'
                        </td>
                        <td>
                        '. (isset($mc->key_code) ? $mc->key_code : '') .'
                        </td>
                        <td>
                            '. (isset($mc->slug) ? $mc->slug : '') .'
                        </td>
                        <td>'. self::active($mc->active) .'</td>
                        <td>
                            '.self::createdAtAndBy($mc).'
                        </td>
                        <td>
                            '.self::updatedAtAndBy($mc).'
                        </td>
                        <td class="btn-group">
                            '. self::editRow($route, $mc) .'
                            '. self::deleteRow($route, $mc) .'
                        </td>
                    </tr>
                ';
            }
        }
        return $html;
    }  

    public static function recursiveSelectMenu($menus, $object = null, $parentId = null, $char = ''){
        $html = '';
        // dd($menus);
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parentId) {
                /* Nếu product hiện tại có menu_id trùng với id của menu hiện tại thì để thuộc tính selected */
                $html .= '
                    <option value='.$menu->id.' '.(!empty($object) && ($object->menu_id == $menu->id || $object->parent_id == $menu->id) ? 'selected' : '').'>
                        '.$char . $menu->name.'
                    </option>
                ';
                
                unset($menus[$key]);

                $html .= self::recursiveSelectMenu($menus, $object, $menu->id, $char . '--');
            }
        }
        return $html;
    }

    public static function filterParents($collects){
        $html = '
        <form action="" class="form-inline">
            <div class="form-group mr-2">
                <select class="custom-select pointer" name="filter-parent">
                    <option value="">---Chọn---</option>
        ';
            foreach ($collects as $item){
                $html .= '
                    <option value="'.$item->id.'" '.(request('filter-parent') == $item->id ? 'selected' : '').'>
                        '.$item->name.'
                    </option>
                ';
            }
        $html .= '
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                Áp dụng
            </button>
        </form>
        ';
        return $html;
    }

    public static function deleteRow($routeName, $object){
        /* Dấu '\': Dùng để nhúng dấu nháy đơn bên trong một dấu nháy đơn khác */
        $html = '
            <button type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#modal-danger"
                    data-route='.route(''.$routeName.'.delete', $object->id).'> 
                <i class="fa-solid fa-trash"></i>
            </button>
         
            <div class="modal fade" id="modal-danger">
                <div class="modal-dialog">
                    <div class="modal-content bg-danger">
                        <form action="" method="POST" id="form-delete">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <div class="modal-header">
                                <h4 class="modal-title">Bạn có chắc muốn xóa ?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Hủy</button>
                                <button type="submit" id="submit-delete" class="btn btn-outline-light">OK</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
            ';
        return $html;
    }

    public static function update($routeName, $id, $message, $action, $submit = 'OK'){
        $modalId = 'modal-' . str_replace('.', '-', $routeName);
        $modalBody = '';
        if($routeName == 'shop.profile.password.update') {
            $modalBody = '
                <div class="form-group">
                    <label for="password">Mật khẩu cũ</label>
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu cũ">
                        <div class="input-group-text pointer show-password"><i class="fa-solid fa-eye-slash"></i></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="new-password">Mật khẩu mới</label>   
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" class="form-control" name="newPassword" placeholder="Nhập mật khẩu mới">
                        <div class="input-group-text pointer show-password"><i class="fa-solid fa-eye-slash"></i></div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="new-password">Nhập lại mật khẩu</label>   
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" class="form-control" name="confirmPassword" placeholder="Nhập lại mật khẩu">
                        <div class="input-group-text pointer show-password"><i class="fa-solid fa-eye-slash"></i></div>
                    </div>
                </div>
            ';
        }
        if($routeName == 'shop.profile.info.update') {
            $modalBody = '
                <div class="form-group">
                    <label for="">Họ tên</label>
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                        <input type="text" class="form-control" name="name" value="'.auth('customer')->user()->name.'" placeholder="Nhập họ tên">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">SĐT</label>   
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                        <input type="text" class="form-control" name="phone" value="'.auth('customer')->user()->phone.'" placeholder="Nhập SĐT">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Địa chỉ</label>   
                    <div class="input-group mb-3">
                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                        <input type="text" class="form-control" name="address" value="'.auth('customer')->user()->address.'" placeholder="Nhập địa chỉ">
                    </div>
                </div>
            ';
        }
        
        $html = '
            <button type="button" class="btn-update flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer"
                data-toggle="modal" data-target="#'.$modalId.'" data-route='.route(''.$routeName.'', $id).'>
                '.$action.'
            </button>

            <div class="modal fade" id="'.$modalId.'">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" method="POST" id="form-update">
                            '.csrf_field().'
                            '.method_field('PUT').'
                            <div class="modal-header">
                                <h4 class="modal-title">'.$message.'</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                '.$modalBody.'
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="submit" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                                    '.$submit.'
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
            ';
        return $html;
    }

    public static function editRow($param1, $param2){
        $html = '
            <a class="btn btn-primary mr-2" href='. route($param1 . '.edit', $param2->id) .'>
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
        ';
        return $html;
    }

    public static function createdAtAndBy($object){
        $html = '';
        if(!empty($object->created_by)){
            $html .= '   
                <div>'.$object->userCreated->name.'</div>
            ';
        }
        $html .= '
            <div>'.$object->created_at->format('Y-m-d').'</div>
        ';
        return $html;
    }

    public static function updatedAtAndBy($object){
        $html = '';
        if(!empty($object->updated_by)){
            $html = '
                <div>'.$object->userUpdated->name.'</div>
            ';
        }
        $html .= '
            <div>'.$object->updated_at->format('Y-m-d').'</div>
        ';
        return $html;
    }

    

    public static function forgotPassword($routeName){
        // $errorHtml = view('admin.errors.error')->render();
        $html = '
            <a href="" id="show-modal-send-email" data-toggle="modal" data-target="#modal-default" 
                data-route='.route(''.$routeName.'').'> 
                Quên mật khẩu ?
            </a>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" method="POST" id="form-send-email">
                            '.csrf_field().'
                            <div class="modal-header">
                                <h4 class="modal-title">Gửi email cấp lại mật khẩu</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text"><i class="fa-solid fa-envelope"></i></div>
                                        <input type="email" class="form-control" name="email" placeholder="Nhập email">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="submit" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                                    Gửi email
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        ';
        return $html;
    }

    public static function active($active){
        return $active == 1 ? 
            '<div><i class="fa-solid fa-circle-check" style="color:green; font-size:40px;"></i></div>' 
                : 
            '<div><i class="fa-solid fa-circle-xmark" style="color:red; font-size:40px;"></i></div>';
    }

    public static function mainMenu($menus, $parentId = null){
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parentId) {
                $html .= '
                    <li>
                        <a class="nav-link" href="'.route('shop.menu.list', $menu->slug).'" id='.$menu->id.'>
                            '. $menu->name .'
                        </a>    
                ';

                unset($menus[$key]);

                /* Kiểm tra nếu menu hiện tại có các menu con */    
                if(self::subMenu($menus, $menu->id)) {
                    // self::subMenu($menus, $menu->id);
                    $html .= '
                        <ul class="sub-menu">
                            '. self::mainMenu($menus, $menu->id) .'
                        </ul>   
                    ';
                }

                $html .= '</li>';
            }
        }
        return $html;
    }
        
    public static function subMenu($menus, $id){
        // dd($menus);
        foreach ($menus as $menu) {
            if($menu->parent_id == $id){
                return true;
            }
        }
        return false;
    }

    public static function price($priceOrigin, $priceSale = 0)
    {
        /* number_format: Ngăn cách số bằng dấu phẩy (VD: 280000 -> 280,000) */
        if ($priceSale != 0){
            $html = '
            <span>
                '.number_format($priceSale).'
            </span>
            <span class="text-decoration-line-through">
                '.number_format($priceOrigin).'
            </span>
            ';
            return $html;
        }
        if ($priceOrigin != 0)  return number_format($priceOrigin);
    }

    public static function getID($param, $column){
        /*  
        - $user->roles()->pluck('role_id'): Sẽ trả về 1 Collection, lấy ra dữ liệu trong cột role_id 
        của user đó
        - toArray(): Phương thức trong Collection, dùng để chuyển thành array
        */
        $result = $param->pluck($column)->toArray();
        $arrayID = [];
        foreach ($result as $item) {
            $arrayID = explode(', ', $item);
        }
        return $arrayID;
    }



}