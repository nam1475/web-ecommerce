<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class Helper{

    public static function menu($menus, $route, $parentId = 0, $char = ''){
        $html = '';
        foreach ($menus as $key => $menu) {
            // dd($menus);
            if ($menu->parent_id == $parentId) {
                $html .= '
                    <tr>
                        <td>'. $menu->id .'</td>
                        <td>'. $char . $menu->name .'</td>
                        <td>'. $menu->description .'</td>
                        <td>'. $menu->parent_id .'</td>
                        <td>'. self::active($menu->active) .'</td>
                        <td>'. $menu->created_at .'</td>
                        <td class="btn-group">
                            '. self::editRow($route, $menu) .'
                            '. self::deleteRow($route, $menu) .'
                        </td>
                    </tr>
                ';

                /* - $menus[$key]: Lấy ra value
                - Loại bỏ mục menu cha vừa lặp qua, để tránh lặp lại menu cha khi đệ quy */
                unset($menus[$key]);

                /* Sử dụng đệ quy để tìm các menu con, gán cho dấu '--' để phân biệt: */ 
                $html .= self::menu($menus, $route, $menu->id, $char . '--');
            }
        }
        return $html;
    }

    public static function deleteRow($param1, $param2){
        $html = '
        <form action=' . route($param1 . '.delete', $param2->id) . ' method="POST"  onsubmit="return confirm(\'Bạn có chắc muốn xóa ?\')">
            '. csrf_field() .' 
            '. method_field("DELETE") .' 
            <button type="submit" class="btn btn-danger m-0">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>';
        return $html;
    }
    
    public static function editRow($param1, $param2){
        $html = '
        <a class="btn btn-primary" href='. route($param1 . '.edit', $param2->id) .'>
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        ';
        return $html;
    }

    public static function active($active){
        return $active == 1 ? 
            '<div><i class="fa-solid fa-circle-check" style="color:green; font-size:40px;"></i></div>' 
                : 
            '<div><i class="fa-solid fa-circle-xmark" style="color:red; font-size:40px;"></i></div>';
    }

    public static function mainMenu($menus, $parentId = 0){
        // dd(1);
        $html = '';
        foreach ($menus as $key => $menu) {
            if ($menu->parent_id == $parentId) {
                /* Str::slug(): Dùng để tạo ra 1 url ngăn cách các chuỗi bởi dấu '-' (VD: giay-the-thao,...) */
                $html .= '
                    <li>
                        <a href="/danh-muc/' . $menu->id . '-' . Str::slug($menu->name, '-') . '.html">
                            '. $menu->name .'
                        </a>
                ';

                unset($menus[$key]);

                if(self::subMenu($menus, $menu->id)) {
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
        foreach ($menus as $menu) {
            if($menu->parent_id == $id){
                return true;
            }
        }
        return false;
    }

    public static function price($price, $priceSale = 0)
    {
        /* number_format: Ngăn cách số bằng dấu phẩy (VD: 280000 -> 280,000) */
        if ($priceSale != 0) return number_format($priceSale);
        if ($price != 0)  return number_format($price);
        return '<a href="/lien-he.html">Liên Hệ</a>';
    }

    public static function getID($param, $column){
        $result = $param->pluck($column)->toArray();
        $arrayID = [];
        foreach ($result as $item) {
            $arrayID = explode(', ', $item);
        }
        return $arrayID;
    }

}