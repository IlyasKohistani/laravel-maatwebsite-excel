<header>
    <nav class="navbar navbar-expand-sm navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="https://www.wamdenim.com/" target="_blank">WAM DENIM</a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
                aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('import.index') }}">Import</a>
                    </li>
                    <li class="nav-link">
                        <!-- Small button groups (default and split) -->
                        <div class="btn-group">
                            <span class="dropdown-toggle" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Exports
                        </span>
                            <ul class="dropdown-menu px-2 bg-dark">
                                <li><a class="nav-link p-0  text-light" href="{{ route('export.all',['type'=>'All_Shop_Details']) }}" style="font-size:12px"><i class="bi bi-file-earmark-arrow-down mr-1"></i>All Shop Details</a></li>
                                <li class="pb-1"><a class="nav-link p-0  text-light" href="{{ route('export.all',['type'=>'Product_Template']) }}" style="font-size:12px"><i class="bi bi-file-earmark-arrow-down mr-1"></i>Product Template</a></li>
                                <li class="pb-1"><a class="nav-link p-0  text-light" href="{{ route('export.all',['type'=>'Shop_Template']) }}" style="font-size:12px"><i class="bi bi-file-earmark-arrow-down mr-1"></i>Shop Template</a></li>
                                <li class="pb-1"><a class="nav-link p-0  text-light" href="{{ route('export.all',['type'=>'Package_Template']) }}" style="font-size:12px"><i class="bi bi-file-earmark-arrow-down mr-1"></i>Package Template</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.wamdenim.com/service/about/"
                            target="_blank">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.wamdenim.com/service/klantenservice/"
                            target="_blank">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
