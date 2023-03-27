<div class="mt-4 text-center">
    <h5 class="mb-4">Sign in with</h5>
    <div class="row">
        <div class="col-6">
            <a class="btn btn-info text-white w-100" href="{{ route('social.login.redirect', ['facebook']) }}"
                rel="nofollow noopener noreferrer">
                <i class="an an-facebook me-2"></i>
            </a>
        </div>
        <div class="col-6">
            <a class="btn btn-danger text-white w-100" href="{{ route('social.login.redirect', ['google']) }}"
                rel="nofollow noopener noreferrer">
                <i class="an an-twitter me-2"></i>
            </a>
        </div>
    </div>
</div>
