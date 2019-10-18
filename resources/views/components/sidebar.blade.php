<ul class="sidebar-menu">
    <li class="{{Nav::regex('screenshot.*', 'active')}}">
        <a href="{{route('screenshot.index')}}">
            <i class="fa fa-camera"></i>تهیه عکس
        </a>
    </li>
    <li class="{{Nav::regex('taradod.*', 'active')}}">
        <a href="{{route('taradod.index')}}">
            <i class="fa fa-sign-in"></i>ثبت تردد
        </a>
    </li>
    <li class="{{Nav::regex('persontocode.*', 'active')}}">
        <a href="{{route('persontocode')}}">
            <i class="fa fa-exchange"></i>ارتباط زائر با کد تردد
        </a>
    </li>
    <li class="{{Nav::regex('localbackup.*', 'active')}}">
        <a href="{{route('localbackup')}}">
            <i class="fa fa-database"></i>لوکال بک آپ
        </a>
    </li>
    <li class="header">
        <i class="fa fa-cogs"></i>
        موارد دیگر
    </li>
    <li class="{{Nav::is('importer', 'active')}}">
        <a href="{{route('importer')}}"><i class="fa fa-database"></i><span>ورود اطلاعات</span></a>
    </li>
    <li class="{{Nav::is('profile', 'active')}}">
        <a href="{{route('profile')}}"><i class="fa fa-edit"></i><span>ویرایش پروفایل</span></a>
    </li>
</ul>