<header class="md-max-1030px-d-block md-max-1030px-h-fc" id="main-header">
    <div class="w-20p">
        <a class="clean-link c-white-2 fs-2-5r user-select-none" href="/">sklopi</a>
    </div>
    
    <div class="d-flex align-items-center justify-content-center gap-5 w-60p mt-m-2px md-max-1030px-mx-auto md-max-600px-gap-1-5rem md-max-1030px-mbl-10px">
        <a class="clean-link c-white-2 fs-1-2r fw-200 hover-c-lgray md-max-400px-fs-0-7rem md-max-600px-fs-0-9rem btn-text-truncate md-max-1030px-min-w-80px" href="/">Početna Stranica</a>
        <a class="clean-link c-white-2 fs-1-2r fw-200 hover-c-lgray md-max-400px-fs-0-7rem md-max-600px-fs-0-9rem" href="/my-builds">Konfigurator</a>
        <a class="clean-link c-white-2 fs-1-2r fw-200 hover-c-lgray md-max-400px-fs-0-7rem md-max-600px-fs-0-9rem" href="/builds">Konfiguracije</a>
        <a class="clean-link c-white-2 fs-1-2r fw-200 hover-c-lgray md-max-400px-fs-0-7rem md-max-600px-fs-0-9rem" href="/discussions">Diskusije</a>
    </div>

    <div class="d-flex align-items-center ml-5 justify-content-end w-20p mt-m-2px">
    @if(Auth::Check())
        <a class="clean-link c-white-2 fs-1-2r hover-c-lgray d-flex my-account-button" href="/my-account">
            <span class="material-symbols-outlined fs-1-8r fw-200 user-select-none">account_circle</span>
            <p class="mb-0px ml-5px fw-light user-select-none">Moj Nalog</p>
        </a>
    @else
        <a class="btn btn-light log-in-button" href="/login">Prijavi Se</a>
    @endif
    </div>
</header>