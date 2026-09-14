<div>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLanguage" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{ strtoupper($currentLang) }}
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownLanguage">
            <a class="dropdown-item" href="#" wire:click="changeLanguage('en')">English</a>
            <a class="dropdown-item" href="#" wire:click="changeLanguage('ar')">العربية</a>
        </div>
    </li>
</div>


