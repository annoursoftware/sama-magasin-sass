<aside class="main-sidebar sidebar-dark-maroon elevation-4">
  <!-- Brand Logo -->
  <a href="../index3.html" class="brand-link">
    <img src="{{ asset('back/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Sama Magasin</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('femme.png') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Ndeye Marie SOW</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{ route('dev.dashboard') }}" class="nav-link {{ request()->is('admin') ? 'active':'' }}">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>
              Tableau de bord
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('admin.systemes.paiements') }}" class="nav-link {{ request()->is('admin/systemes-paiements') ? 'active':'' }}">
            <i class="nav-icon bi bi-cash-coin"></i>
            <p>Systémes de Paiement <span class="right badge badge-danger">{{ $nb_moyens_paiements }}</span></p>
          </a>
        </li>

        <li class="nav-header">INVENTAIRES</li>
        <li class="nav-item {{ request()->is('admin/inventaires/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/inventaires/*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-basket-fill"></i>
            <p>
              Inventaires
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.inventaires.categories') }}"
                class="nav-link {{ request()->is('admin/inventaires/categories') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Catégories<span class="right badge badge-danger">{{ $nb_categories }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.inventaires.marques') }}"
                class="nav-link {{ request()->is('admin/inventaires/marques') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Marques<span class="right badge badge-danger">{{ $nb_marques }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.inventaires.articles') }}"
                class="nav-link {{ request()->is('admin/inventaires/articles') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Articles<span class="right badge badge-danger">{{ $nb_articles }}</span></p>
              </a>
            </li>
          </ul>
        </li>
        
        {{-- <li class="nav-header">LIVRAISONS</li>
        <li class="nav-item {{ request()->is('admin/livraisons/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/livraisons/*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-basket-fill"></i>
            <p>
              Livraisons
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.livraisons.livreurs') }}"
                class="nav-link {{ request()->is('admin/livraisons/livreurs') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Livreurs<span class="right badge badge-danger">{{ $nb_categories }}</span></p>
              </a>
            </li>
          </ul>
        </li> --}}

        <li class="nav-header">RECETTES</li>
        
        <li class="nav-item">
          <a href="{{ route('admin.transactions.clients') }}" class="nav-link {{ request()->is('admin/transactions/clients') ? 'active':'' }}">
            <i class="nav-icon bi bi-people"></i>
            <p> Clients <span class="right badge badge-danger">{{ $nb_clients }}</span></p>
          </a>
        </li>

        <li class="nav-item {{ request()->is('admin/transactions/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/transactions/*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-cart-dash-fill"></i>
            <p>
              Ventes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            {{-- <li class="nav-item">
              <a href="{{ route('admin.transactions.clients') }}"
                class="nav-link {{ request()->is('admin/transactions/clients') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Clients<span class="right badge badge-danger">{{ $nb_clients }}</span></p>
              </a>
            </li> --}}
            <li class="nav-item">
              <a href="{{ route('admin.transactions.ventes.devis.nouveau') }}"
                class="nav-link {{ request()->is('admin/transactions/ventes/devis/nouveau') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nouveau devis<span class="right badge badge-danger">{{-- {{ $nb_ventes }} --}}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.transactions.ventes.vente.nouveau') }}"
                class="nav-link {{ request()->is('admin/transactions/ventes/vente/nouveau') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nouvelle vente<span class="right badge badge-danger">{{-- {{ $nb_ventes }} --}}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.transactions.ventes') }}"
                class="nav-link {{ request()->is('admin/transactions/ventes') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Ventes<span class="right badge badge-danger">{{ $nb_ventes }}</span></p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('admin/prestations/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/prestations/*') ? 'active' : '' }}">
            <i class="bi bi-tools"></i>
            <p>
              Prestations
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.prestations.activites') }}"
                class="nav-link {{ request()->is('admin/prestations/activites') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Activités<span class="right badge badge-danger">{{ $nb_activites }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.prestations.devis.nouveau') }}"
                class="nav-link {{ request()->is('admin/prestations/devis/nouveau') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nouveau devis<span class="right badge badge-danger">{{-- {{ $nb_ventes }} --}}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.prestations.facture.nouveau') }}"
                class="nav-link {{ request()->is('admin/prestations/facture/nouveau') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nouvelle facture<span class="right badge badge-danger">{{-- {{ $nb_ventes }} --}}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.prestations.prestations') }}"
                class="nav-link {{ request()->is('admin/prestations/prestations') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Prestations<span class="right badge badge-danger">{{ $nb_prestations }}</span></p>
              </a>
            </li>
          </ul>
        </li>

        
        <li class="nav-header">DEPENSES</li>
        <li class="nav-item {{ request()->is('admin/depenses/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/depenses/*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-cart-plus-fill"></i>
            <p>
              Achats
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.depenses.achats.fournisseurs') }}"
                class="nav-link {{ request()->is('admin/depenses/achats/fournisseurs') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Fournisseurs<span class="right badge badge-danger">{{ $nb_fournisseurs }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.depenses.achats.facture.nouveau') }}"
                class="nav-link {{ request()->is('admin/depenses/achats/facture/nouveau') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nouvelle facture<span class="right badge badge-danger">{{-- {{ $nb_ventes }} --}}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.depenses.achats.achats') }}"
                class="nav-link {{ request()->is('admin/depenses/achats/achats') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Achats<span class="right badge badge-danger">{{ $nb_achats }}</span></p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('admin/productions/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/productions/*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-cart-plus-fill"></i>
            <p>
              Productions
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.productions.ingredients') }}"
                class="nav-link {{ request()->is('admin/productions/ingredients') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Ingredients<span class="right badge badge-danger">{{ $nb_ingredients }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.productions.produits') }}"
                class="nav-link {{ request()->is('admin/productions/produits') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Produits<span class="right badge badge-danger">{{ $nb_produits }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.productions.productions.facture.nouveau') }}"
                class="nav-link {{ request()->is('admin/productions/productions/facture/nouveau') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nouvelle production<span class="right badge badge-danger">{{-- {{ $nb_ventes }} --}}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.productions.productions') }}"
                class="nav-link {{ request()->is('admin/productions/productions') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Productions<span class="right badge badge-danger">{{ $nb_productions }}</span></p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item {{ request()->is('admin/autres-depenses/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/autres-depenses/*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-receipt"></i>
            <p>
              Dépenses
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.autres-depenses.beneficiaires') }}" class="nav-link {{ request()->is('admin/autres-depenses/beneficiaires') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Bénéficiaires <span class="right badge badge-danger">{{ $nb_beneficiaires }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.autres-depenses.depense.nouveau') }}"
                class="nav-link {{ request()->is('admin/autres-depenses/depense/nouveau') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Nouvelle dépense<span class="right badge badge-danger">{{-- {{ $nb_ventes }} --}}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.autres-depenses.depenses') }}" class="nav-link {{ request()->is('admin/autres-depenses/depenses') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Dépenses <span class="right badge badge-danger">{{ $nb_depenses }}</span></p>
              </a>
            </li>
          </ul>
        </li>

        
        <li class="nav-header">FINANCES</li>
        
        <li class="nav-item {{ request()->is('admin/finances/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/finances/*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i>
            <p>
              Finances
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.finances.encaissements') }}"
                class="nav-link {{ request()->is('admin/finances/encaissements') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Encaissements<span class="right badge badge-danger">{{ $nb_encaissements }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.finances.decaissements') }}"
                class="nav-link {{ request()->is('admin/finances/decaissements') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Decaissements<span class="right badge badge-danger">{{ $nb_encaissements }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.finances.encaissements') }}"
                class="nav-link {{ request()->is('admin/finances/encaissements') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Créances<span class="right badge badge-danger">{{ $nb_encaissements }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.finances.encaissements') }}"
                class="nav-link {{ request()->is('admin/finances/encaissements') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Dettes<span class="right badge badge-danger">{{ $nb_encaissements }}</span></p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header">RH</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-person-raised-hand"></i>
            <p>
              Ressources Humaines
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../index.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Employés</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../index2.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Paies</p>
              </a>
            </li>
          </ul>
        </li>


        <li class="nav-header">WEBSITE</li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-globe2"></i>
            <p>
              WEBSITE
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../index.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Catégories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../index2.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Services</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../index3.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Posts</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../index3.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Témoignages</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-header">ACL</li>
        <li class="nav-item {{ request()->is('admin/acl/*') ? ' menu-open' : '' }}">
          <a href="#" class="nav-link {{ request()->is('admin/acl/*') ? 'active' : '' }}">
            <i class="nav-icon bi bi-shield-shaded"></i>
            <p> ACL <i class="right fas fa-angle-left"></i></p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('admin.acl.roles') }}"
                class="nav-link {{ request()->is('admin/acl/roles') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Rôles<span class="right badge badge-danger">{{ $nb_roles }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.acl.entreprises') }}"
                class="nav-link {{ request()->is('admin/acl/entreprises') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Entreprises<span class="right badge badge-danger">{{ $nb_entreprises }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.acl.boutiques') }}"
                class="nav-link {{ request()->is('admin/acl/boutiques') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Boutiques<span class="right badge badge-danger">{{ $nb_boutiques }}</span></p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.acl.utilisateurs') }}"
                class="nav-link {{ request()->is('admin/acl/utilisateurs') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Utilisateurs<span class="right badge badge-danger">{{ $nb_users }}</span></p>
              </a>
            </li>
          </ul>
        </li>


        {{-- <li class="nav-item">
          <a href="{{ route('admin.profile') }}" class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
            <i class="nav-icon fas fa-address-card"></i>
            <p>Profile</p>
          </a>
        </li> --}}

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-cash-coin"></i>
            <p>Abonnements</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-power-off"></i>
            <p>Deconnexion</p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>