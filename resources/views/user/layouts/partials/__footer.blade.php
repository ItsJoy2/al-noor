          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block"> © {{ date('Y') }} <a href="{{ route('user.dashboard') }}">{{ $generalSettings->app_name ?? '3TwentySoft' }}</a></span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Developed by <a href="https://3twentysoft.com"target="_blank">3TwentySoft</a> </span>
            </div>
          </footer>
          <!-- partial -->
