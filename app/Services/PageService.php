<?php

namespace App\Services; 
use App\Models\Page;

class PageService {
    public function getPageById($id) {
        $page = Page::findOrFail($id);
    }   
}