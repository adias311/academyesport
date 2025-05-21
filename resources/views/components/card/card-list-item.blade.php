<div class="list-group-item">
    <div class="row row-sm align-items-center">
        <div class="col-auto text-h3">
            <span class="avatar">{{ $eps }}</span>
        </div>
        <a href="{{ $uri }}" class="col">
            {{ $title }}
        </a>
        <div class="col-auto text-muted">
            {{ $duration }}          
        </div>
        <div class="col-auto">
            @if($intro && $duration == "")
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  
                stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  
                class="icon icon-tabler icons-tabler-outline icon-tabler-file-dots text-teal">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                <path d="M9 14v.01" />
                <path d="M12 14v.01" />
                <path d="M15 14v.01" />
            </svg>            
            @elseif ($intro)
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-player-play text-teal"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M7 4v16l13 -8z"></path>
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-coin text-red" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 0 0 0 4h2a2 2 0 0 1 0 4h-2a2 2 0 0 1 -1.8 -1">
                    </path>
                    <path d="M12 6v2m0 8v2"></path>
                </svg>
            @endif
        </div>
        <div class="col-auto">
            <div class="dropdown">
                <a href="#" class="link-secondary" data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg"
                        class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z"></path>
                        <circle cx="5" cy="12" r="1"></circle>
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                    </svg>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
