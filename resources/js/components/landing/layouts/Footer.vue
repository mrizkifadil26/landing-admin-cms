<template>
  <footer class="bg-primary" id="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="row">
            <span class="copyright">Copyright &copy; Muhammad Rizki Fadillah 2018</span>
          </div>
          <div class="row text-center">
            <ul class="list-inline quicklinks">
              <li class="list-inline-item">
                <a href="#">Privacy Policy</a>
              </li>
              <li class="list-inline-item">
                <a href="#">Terms of Use</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <ul class="list-inline social-buttons">
            <li class="list-inline-item">
              <a href="https://www.facebook.com/pemkotcilegon/">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://twitter.com/pemkotcilegon">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://www.instagram.com/pemkotcilegon/">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-md-2">
          <a href="http://indosatooredoo.com/" target="_blank">
            <img src="/img/ooredoo.png" alt="Indosat Ooredoo">
          </a>
        </div>
        <div class="col-md-2">
          <a href="https://play.google.com/store/apps/details?id=org.smart.nation.indonesia.android.cilegon&pcampaignid=MKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1" target="_blank">
            <img alt="Get it on Google Play" src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png" />
          </a>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>

export default {
  name: 'Footer'
}

</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

footer {
  padding: 25px 0;
  text-align: center;
  color: #fff;
}

footer a {
  color: #fff;
}

footer img {
  max-height: 72px;
}

footer span.copyright {
  font-size: 90%;
  line-height: 40px;
  text-transform: none;
  font-family: 'Open Sans', 'Helvetica', Arial, sans-serif;
}

footer ul.quicklinks {
  font-size: 90%;
  line-height: 40px;
  margin-bottom: 0;
  text-transform: none;
  font-family: 'Open Sans', 'Helvetica', Arial, sans-serif;
}

ul.social-buttons {
  margin-bottom: 0;
}

ul.social-buttons li a {
  font-size: 20px;
  line-height: 50px;
  display: block;
  width: 50px;
  height: 50px;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
  color: #212529;
  border-radius: 100%;
  outline: none;
  background-color: #fff;
}

ul.social-buttons li a:active, ul.social-buttons li a:focus, ul.social-buttons li a:hover {
  background-color: #212529;
  color: #FFF;
}

</style>
