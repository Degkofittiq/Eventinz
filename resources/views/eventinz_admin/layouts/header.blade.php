<style>
  #no-hover:hover{
    text-decoration: none;
  }
  #no-hover{
    text-decoration: none;
  }
  .img-size-50{
    width: 30px !important;
  }
  
  .notif-section{
        position: relative;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
    }
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ request()->url() == route('admin.dashboard') ? "/" : route('admin.dashboard')  }}" class="nav-link">Home</a>
        {{-- <a href="#{{ asset('AdminTemplate/index3.html')}}" class="nav-link">Home</a> --}}
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ asset('AdminTemplate/index.html') }}" target="_blank" class="nav-link">AdminLTE pages raccourci</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>


      <script>
        async function fetchConversations() {
            const response = await fetch('/api/conversations', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + '{{ $userToken }}'  // Remplacez par le token de l'utilisateur authentifié
                }
            });
      
            if (response.ok) {
                const conversations = await response.json();
                const conversationsList = document.getElementById('conversationsList');
                conversationsList.innerHTML = ''; // Vider la liste actuelle
      
                conversations.forEach(conversation => {
                    const lastMessage = conversation.lastMessage ? conversation.lastMessage.body : 'Aucun message';
                    const otherUser = conversation.otherUser; // Obtenez l'utilisateur opposé
                    const listItem = document.createElement('li');
                    const profileImage = otherUser.profile_image ? otherUser.profile_image : '{{ asset('AdminTemplate/dist/img/user-avatars-thumbnail_2.png') }}';

                    listItem.innerHTML = `
                      <a href="/admin/conversations/${conversation.conversation.id}/messages" class="dropdown-item">
                        <!-- Message Start -->
                        <div class="media">
                          <img src="${profileImage}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                          <div class="media-body">
                            <h3 class="dropdown-item-title">
                              ${otherUser.username} <!-- Utilisateur opposé -->
                              <!--span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span-->
                            </h3>
                            <p class="text-sm">${lastMessage}</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                          </div>
                        </div>
                        <!-- Message End -->
                      </a>
                      <div class="dropdown-divider"></div>
                    `;
                    
                    conversationsList.appendChild(listItem);
                });
            } else {
                console.error('Erreur lors de la récupération des conversations');
            }
        }
      
        // Appeler la fonction pour récupérer les conversations
        fetchConversations();
      </script>


      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          {{-- <span class="badge badge-danger navbar-badge">3</span> --}}
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="div" id="conversationsList">

          </div>
          <script>
            async function fetchConversations() {
              const response = await fetch('/api/conversations', {
                method: 'GET',
                headers: {
                  'Authorization': 'Bearer ' + '{{ $userToken }}'  // Remplacez par le token de l'utilisateur authentifié
                }
              });
          
              if (response.ok) {
                const conversationsContent = await response.json();
                const conversationsContentList = document.getElementById('conversationContent');
                let content = '';  // Utilisation de chaîne vide au lieu de `null`
          
                // Vérifie s'il n'y a pas de conversations
                if (conversationsContent.length <= 0) {
                  content = `<span class="dropdown-item dropdown-footer">No conversation yet</span>`;
                } else {
                  content = `<a href="{{ route('my.conversations') }}" class="dropdown-item dropdown-footer">See All Messages</a>`;
                }
          
                // Insérer le contenu généré dans l'élément
                conversationsContentList.innerHTML = content;
              } else {
                console.error('Erreur lors de la récupération des conversations');
              }
            }
          
            // Appeler la fonction pour récupérer les conversations
            fetchConversations();
          </script>
          
          <div id="conversationContent"></div>
          
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        {{-- <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a> --}}
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-gears"></i>Settings
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">Account</span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('admin.edit.adminuserform',Auth::user()->id) }}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> My Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item" id="no-hover">
            <form action="{{ route('admin.logout') }}" method="post">
              @csrf
              <button type="submit" class="btn" style="padding-left: 0px !important">
                <i class="fas fa-sign-out-alt mr-2" style="text-decoration: none"></i> 
                Loggout
              </button>
            </form>
          </a>
        </div>
      </li>
    </ul>
  </nav>