<header class="bg-amber-600">
    <div class="mx-auto container px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <?php get_template_part('template-parts/header/site-branding'); ?>
            <div class="flex items-center gap-4">
            <?php if ( is_user_logged_in() ) { ?>
          <a
            class="rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow"
            href="<?php echo wp_logout_url(); ?>"
          >
          Logout
          </a>

          <img src="https://placehold.co/40x40" alt="" class="rounded-full">

          <?php } else { ?>
          <a
            class="popuplink rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white shadow"
            href="#popup-login-form"
          >
            Login
          </a>

          <div class="hidden sm:flex">
            <a
              class="popuplink rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600"
              href="#popup-register-form"
            >
              Register
            </a>
          </div>
          <?php } ?>

            </div>
        </div>
    </div>
</header>