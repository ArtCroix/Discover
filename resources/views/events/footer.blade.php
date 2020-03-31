<footer class="footer container-fluid mx-0">
    <div class="footer__container row no-gutters align-items-center my-2 mx-auto">
        <div class="col-sm-10 text-center mx-auto">
            <img src="{{ url('/images/common/wswords.png') }}" height="100" align="left">
            <img src="{{ url('/images/common/discover.png') }}" height="100" align="right">
            <p>
                <a href="https://facebook.com/moscowicpc" class="text-white footer__social-href" target="_blank">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://vk.com/moscowicpc" class="text-white footer__social-href pl-4" target="_blank">
                    <i class="fab fa-vk"></i>
                </a>
                <a href="https://www.instagram.com/moscowicpc/" class="text-white footer__social-href pl-4" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            </p>
            <p class="my-0 text-white">
                Copyright © 2020 Moscow Workshops
            </p>
            <p class="my-0">
                <a class="text-white" href="mailto:workshops@it-edu.com">workshops@it-edu.com</a>
            </p>
            <p class="my-0">
                <a class="text-white" href="tel:+79299787555" target="_blank">+7(929)97-87-555</a>
            </p>
            <p class="my-0">
                <a class="text-white" href="{{ url('/docs/agreement_' . app()->getLocale() . '.docx') }}">{{ __('Согласие на обработку персональных данных') }}</a>
            </p>
        </div>
    </div>
</footer>
