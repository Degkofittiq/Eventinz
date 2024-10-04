@extends('eventinz_admin.layouts.app')
@section('content_admin')
<style>
    #conversationsList2 li{
        list-style-type:none !important;
    }
    #conversationsList2 ul{
        text-decoration: none !important;
    }

    .notif-section{
        position: relative;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: .25rem;
    }
</style>
<div class="card card-primary">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
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
                const conversationsList = document.getElementById('conversationsList2');
                if (conversations.lenght > 0) {
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
                }
            } else {
                console.error('Erreur lors de la récupération des conversations');
            }
        }
      
        // Appeler la fonction pour récupérer les conversations
        fetchConversations();
    </script>
    <div id="conversationsList2" style="padding-top: 5px">
        <div class="notif-section">No converstion yet</div>
    </div>
</div>
@endsection