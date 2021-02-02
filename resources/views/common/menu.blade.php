<ul>
    <li class="py-1">
        <a href="{{ route('deploy', ['site' => $site]) }}" class="hover:text-green-600 py-3 {{ request()->routeIs('deploy') ? 'text-green-600' : '' }}">
            <i class="fab fa-octopus-deploy"></i> Deploy
        </a>
    </li>
    <li class="py-1">
        <a href="{{ route('queue', ['site' => $site]) }}" class="hover:text-green-600 py-3 {{ request()->routeIs('queue') ? 'text-green-600' : '' }}">
            <i class="fas fa-sliders-h"></i> Queue
        </a>
    </li>
</ul>
