{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('company') }}"><i class="nav-icon la la-suitcase"></i> Sociétés</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('formule') }}"><i class="nav-icon la la-list"></i> Formules</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i class="nav-icon la la-shopping-cart"></i> Payments</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('abonnement') }}"><i class="nav-icon la la-check-circle"></i> Abonnements</a></li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon la la-id-badge"></i> Badges</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('badges') }}"><i
                    class="nav-icon la la-id-badge"></i> Badges</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('badges/generate') }}"><i
                    class="nav-icon la la-plus-circle"></i> <span>Générer</span></a></li>
    </ul>
</li>
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#">
        <i class="nav-icon la la-qrcode"></i> QR Codes</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('qr_codes') }}"><i class="nav-icon la la-qrcode"></i> Attribuer QR Code</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('qr_codes/generate') }}"><i
                    class="nav-icon la la-plus-circle"></i> <span>Générer QR Codes</span></a></li>
    </ul>
</li>
<li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-cog"></i> Administrations</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon la la-chart-bar"></i> Rapports</a>
            <ul class="nav-dropdown-items">
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('rapports') }}"><i
                            class="nav-icon la la-cart-plus"></i> Ventes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('stats') }}"><i
                            class="nav-icon la la-list"></i> <span>Statistiques</span></a></li>
            </ul>
        </li>

        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon la la-users"></i> Authentication</a>
            <ul class="nav-dropdown-items">
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i
                            class="nav-icon la la-user"></i> Utilisateurs</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i
                            class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i
                            class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
            </ul>
        </li>
    </ul>
</li>


