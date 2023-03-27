<footer class="ai-app-footer py-2">
    <div class="row w-100">
        <div class="col-md-12">
            <span>
                {!! sanitize_html(
                    setting(
                        '_footer_copyright',
                        '© 2022 DotArtisan, LLC. All rights reserved. <span class="float-end">Powered By: <a href="https://dotartisan.com">DotArtisan, LLC</span></a>',
                    ),
                ) !!}
            </span>
        </div>
    </div>
</footer>
