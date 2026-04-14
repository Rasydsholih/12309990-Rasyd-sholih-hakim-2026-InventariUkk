<style>
    body {
        display: flex;
    }

    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #264299;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        padding-top: 20px; 
    }

    .sidebar .section-title {
        color: #e2e8f0;
        font-size: 14px;
        padding: 10px 20px;
        margin-top: 10px;
        margin-bottom: 0;
    }

    .sidebar .nav-link {
        color: #ffffff;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 0; 
        transition: 0.3s;
        display: flex;
        align-items: center;
    }

    .sidebar .nav-link i.icon {
        margin-right: 15px;
        font-size: 1.2rem;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: #1e337c;  
        color: #ffffff;
    }

    .sidebar .nav-link .bi-chevron-right {
        margin-left: auto;
        font-size: 0.9rem;
    }

    .sidebar .collapse .nav-link {
        padding-left: 55px; 
        font-weight: 400;
    }

    .content {
        margin-left: 260px;
        padding: 20px;
        width: calc(100% - 260px);
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }
</style>

<div class="sidebar">
    <div class="section-title">Menu</div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-layout-sidebar icon"></i> Dashboard
            </a>
        </li>
        
            <li class="nav-item">
                <a class="nav-link" href="{{ route('categories.index') }}">
                    <i class="bi bi-tags icon"></i> Categories
                </a>
            </li>

        <div class="section-title">Items Data</div>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('items.index') }}">
                <i class="bi bi-pie-chart icon"></i> Items
            </a>
        </li>


            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="bi bi-arrow-repeat icon"></i> Lending
                </a>
            </li>
        
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#usersMenu" role="button">
                <i class="bi bi-person icon"></i> Users
                <i class="bi bi-chevron-right"></i>
            </a>

            <ul class="collapse list-unstyled" id="usersMenu">
                    <li>
                        <a href="#" class="nav-link">• Admin</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">• Operator</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">• Edit Profile</a>
                    </li>
            </ul>
        </li>

    </ul>
</div>