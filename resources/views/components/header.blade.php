<header id="main-header">
    <div class="w-20p">
        <a class="clean-link c-white-2 fs-2-5r user-select-none" href="/">sklopi</a>
    </div>
    
    <div class="d-flex align-items-center justify-content-center gap-5 w-60p mt-m-2px">
        <a class="clean-link c-white-2 fs-1-2r fw-light hover-c-lgray" href="/">Početna Stranica</a>
        <a class="clean-link c-white-2 fs-1-2r fw-light hover-c-lgray" href="/builder">Konfigurator</a>
        <a class="clean-link c-white-2 fs-1-2r fw-light hover-c-lgray" href="/builds">Konfiguracije</a>
        <a class="clean-link c-white-2 fs-1-2r fw-light hover-c-lgray" href="/discussions">Diskusije</a>
    </div>

    <div class="d-flex align-items-center ml-5 justify-content-end w-20p mt-m-2px">
    @if(Auth::Check())
        <a class="clean-link c-white-2 fs-1-2r hover-c-lgray" href="/my-account">Moj Nalog</a>
    @else
        <a class="clean-link c-white-2 fs-1-2r hover-c-lgray" href="/login">Prijavi Se</a>
    @endif
    </div>
</header>