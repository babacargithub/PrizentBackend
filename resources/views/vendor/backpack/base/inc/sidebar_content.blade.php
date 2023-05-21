{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ backpack_url('company') }}"><i class="nav-icon la la-suitcase"></i> Sociétés</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('formule') }}"><i class="nav-icon la la-list"></i> Formules</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('payment') }}"><i class="nav-icon la la-shopping-cart"></i> Payments</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('abonnement') }}"><i class="nav-icon la la-check-circle"></i> Abonnements</a></li>
<li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-cog"></i> Administrations</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item nav-dropdown">
            <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon la la-chart-bar"></i> Rapports</a>
            <ul class="nav-dropdown-items">
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('rapports') }}"><i
                            class="nav-icon la la-cart-plus"></i> Ventes du jr</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('soldes') }}"><i
                            class="nav-icon la la-wallet"></i> <span>Soldes</span></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ backpack_url('stats') }}"><i
                            class="nav-icon la la-list"></i> <span>Statistiques</span></a></li>
            </ul>
        </li>

        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('abonnement') }}"><i
                    class="nav-icon la la-user"></i> Utilisateurs</a></li>
    </ul>
</li>


