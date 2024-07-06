<?php
namespace App\Traits;

trait ParentAndChildrenRelationship
{
    public function parent()
    {
        // Sử dụng late static binding để lấy class khi gọi trait
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    /** Quan hệ Cha-Con 
    * Hàm này sẽ lấy tất cả các menu con của menu cha
    */
    public function children()
    {
        return $this->hasMany(static::class, 'parent_id', 'id');
    }

    /** Quan hệ Đệ Quy
    * Hàm này trả về tất cả các mục con của một menu, bao gồm các mục con trực tiếp và tất cả các mục con của 
    * chúng một cách đệ quy
    * with('childrenRecursive') hay $this->childrenRecursive(): Sử dụng đệ quy để tiếp tục tìm menu con 
    * của menu cha
    */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}