<?php
 
 namespace App\Repositories\Admin\SidebarSlider;

 interface SidebarSliderRepositoryInterface
 {
     public function store($request);
     public function update($request, $id);
     public function delete($id);
     public function get();
     public function getById($id);
 }