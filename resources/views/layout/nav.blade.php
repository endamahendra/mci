<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="/product">
              <i class="bi bi-circle"></i><span>Produk</span>
            </a>
          </li>
          <li>
            <a href="/category">
              <i class="bi bi-circle"></i><span>Kategori</span>
            </a>
          </li>
          <li>
            <a href="/customer">
              <i class="bi bi-circle"></i><span>Pelanggan</span>
            </a>
          </li>
          {{-- <li>
            <a href="/supplier">
              <i class="bi bi-circle"></i><span>Supplier</span>
            </a>
          </li> --}}
    </ul>
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#transaksi" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Data Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
    <ul id="transaksi" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            </a>
          </li>
          <li>
            <a href="/purchaseorder">
              <i class="bi bi-circle"></i><span>Purchase Order</span>
            </a>
          </li>
          <li>
            <a href="/salesorder">
              <i class="bi bi-circle"></i><span>Sales Order</span>
            </a>
          </li>
    </ul>
    <li class="nav-item">
        <a class="nav-link" href="/user">
            <i class="bi bi-menu-button-wide"></i><span>Data User</span>
        </a>
    </li>


</aside>
