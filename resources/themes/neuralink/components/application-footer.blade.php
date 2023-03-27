  @if (setting('footer_copyright_bar', 1) == 1 || setting('footer_widgets', 0) == 1)
      <footer class="footer">
          @guest
              <div class="footer-top">
                  <div class="container">
                      <div class="row">
                          <div class="col-md-9">
                              <div class="footer-top-contant d-flex align-items-center">
                                  <i class="an an-exclamation-circle"></i>
                                  <span>@lang('common.footerCta')</span>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="action text-sm-center">
                                  <button href="#" class="btn btn-primary">Try Free Now</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          @endguest
          @if (setting('footer_widgets', 1) == 1)
              <div class="contant">
                  <div class="container">
                      <div class="row">
                          @for ($i = 1; $i <= setting('footer_widget_columns', 4); $i++)
                              <div class="col">
                                  @if (!Widget::group("footer-{$i}")->isEmpty())
                                      @widgetGroup("footer-{$i}")
                                  @endif
                              </div>
                          @endfor
                      </div>
                  </div>
              </div>
          @endif
          <div class="footer-bottom">
              <div class="container">
                  <div class="row">
                      <div class="col-md-6">
                          <div class="footer-logo navbar-brand">
                              <x-application-logo />
                          </div>
                      </div>
                      @if (
                          !empty(setting('social_links_facebook', false)) ||
                              !empty(setting('social_links_twitter', false)) ||
                              !empty(setting('social_links_linkedin', false)) ||
                              !empty(setting('social_links_youtube', false)))
                          <div class="col-md-6">
                              <div class="social">
                                  <ul class="nav">
                                      @if (!empty(setting('social_links_facebook', false)))
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ setting('social_links_facebook', false) }}"
                                                  target="_blank" rel="noreferrer noopener">
                                                  <i class="an an-facebook"></i>
                                              </a>
                                          </li>
                                      @endif
                                      @if (!empty(setting('social_links_twitter', false)))
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ setting('social_links_twitter', false) }}"
                                                  target="_blank" rel="noreferrer noopener">
                                                  <i class="an an-twitter"></i>
                                              </a>
                                          </li>
                                      @endif
                                      @if (!empty(setting('social_links_linkedin', false)))
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ setting('social_links_linkedin', false) }}"
                                                  target="_blank" rel="noreferrer noopener">
                                                  <i class="an an-linkedin-in"></i>
                                              </a>
                                          </li>
                                      @endif
                                      @if (!empty(setting('social_links_youtube', false)))
                                          <li class="nav-item">
                                              <a class="nav-link" href="{{ setting('social_links_youtube', false) }}"
                                                  target="_blank" rel="noreferrer noopener">
                                                  <i class="an an-youtube"></i>
                                              </a>
                                          </li>
                                      @endif
                                  </ul>
                              </div>
                          </div>
                      @endif
                  </div>
              </div>
          </div>
          @if (setting('footer_copyright_bar', 1) == 1)
              <div class="copyright">
                  <div class="container">
                      <div class="row">
                          <div class="col-md-12 {{ setting('footer_center_copyright', 1) == 1 ? ' text-center' : '' }}">
                              <p class="mb-0">
                                  {!! sanitize_html(
                                      setting(
                                          '_footer_copyright',
                                          '© 2022 DotArtisan, LLC. All rights reserved. <span class="float-end">Powered By: <a href="https://dotartisan.com">DotArtisan, LLC</span></a>',
                                      ),
                                  ) !!}
                              </p>
                          </div>
                      </div>
                  </div>
              </div>
          @endif
      </footer>
  @endif
