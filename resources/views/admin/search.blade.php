<div class="d-flex align-items-center justify-content-between my-3 mx-3">
    @yield('filter')
    
    <form action="">
        <div class="input-group">
            <input type="text" id="searchInput" name="search" class="form-control bg-light border-1 small" placeholder="Tìm kiếm theo id hoặc tên..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search fa-sm"></i>      
                </button>
            </div>    
        </div>
    </form>
</div>