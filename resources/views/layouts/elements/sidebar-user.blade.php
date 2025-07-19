<div class="relative user-panel pb-12 d-flex align-items-start hv-brightness"
    style="
    box-shadow: 0px 0px 20px  rgba(255,255,255,0.6);
    position: relative;
    background-image: url('{{ $userCover }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;">

    <!-- Overlay tối -->
    <div
        style="
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(0,0,0,0.2), rgba(0,0,0,0.6));
        z-index: 1;
    ">
    </div>
    <a onclick="event.preventDefault(); Livewire.emit('viewRender','profiles.index')" href="#"
        class=" absolute inset-0 z-10" style="z-index: 100"></a>

    <!-- phần nội dung thật -->
    <div class="p-0 mb-4 m-0 shrink-0 flex items-center gap-2 z-20">
        <!-- avatar -->
        <img src="{{ asset($userAvatar) }}"
            onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png';"
            class="mt-3 img-circle elevation-2 object-cover user-avatar border-role-{{ $userRole }}"
            alt="User Image" style="width: 60px;border: 5px solid {{ $roleColor }}">
    </div>

    <div class="user-role-badge transition-opacity opacity-100 p-0 flex justify-center absolute w-full z-20">
        <span class="truncate block max-w-[120px] px-2 py-1 text-white rounded-full"
            style="background-color: {{ $roleColor ?? '#4b6cb7' }};">
            {{ $userRole }}
        </span>

        <div class="flex user-username">
            <span class="truncate ml-2 pointer-events-auto"
                style="max-width:100px; text-decoration: none; color: inherit;">
                <i>{{ '@' . $username }}</i>
            </span>
        </div>
    </div>

    <div class="ml-3 mt-4 max-w-[65%] z-20">
        <span class="truncate user-alias block">
            <b>{{ $userAlias }}</b>
        </span>
    </div>
</div>
