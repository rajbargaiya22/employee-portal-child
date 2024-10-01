<?php
/**
 * The template for displaying search forms in employee-portal
 *
 * @package astra-child
 */
?>
<div class="search-form-container">
<form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>" class="searchform">
  <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s"  placeholder="<?php echo esc_attr__('Search...', 'astra-child'); ?>" autocomplete="off" />
    <label for="searchsubmit">
      <input type="submit" id="searchsubmit" value="<?php echo esc_attr__('Search', 'astra-child'); ?>" class=""/>
      <span class="screen-reader-text">
        <?php echo esc_html(get_theme_mod('rj_bookmarks_search_button',__('Search','astra-child')));?>
      </span>
      <svg width="44" zoomAndPan="magnify" viewBox="0 0 33 32.999998" height="44" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="9ac1ef186f"><path d="M 20 20 L 31.949219 20 L 31.949219 31.949219 L 20 31.949219 Z M 20 20 " clip-rule="nonzero"/></clipPath><clipPath id="6584e6c491"><path d="M 1.199219 1.199219 L 25 1.199219 L 25 25 L 1.199219 25 Z M 1.199219 1.199219 " clip-rule="nonzero"/></clipPath></defs><rect x="-3.3" width="39.6" fill="#ffffff" y="-3.3" height="39.599998" fill-opacity="1"/><rect x="-3.3" width="39.6" fill="#ffffff" y="-3.3" height="39.599998" fill-opacity="1"/><path fill="#000000" d="M 19.085938 21.003906 L 21.003906 19.085938 L 24.890625 22.976562 L 22.976562 24.894531 Z M 19.085938 21.003906 " fill-opacity="1" fill-rule="nonzero"/><g clip-path="url(#9ac1ef186f)"><path fill="#000000" d="M 31.035156 26.945312 C 31.882812 27.792969 31.882812 29.164062 31.035156 30.011719 L 30.011719 31.035156 C 29.164062 31.882812 27.792969 31.882812 26.945312 31.035156 L 21.46875 25.554688 C 20.621094 24.707031 20.621094 23.335938 21.464844 22.488281 L 22.488281 21.464844 C 23.335938 20.621094 24.710938 20.621094 25.554688 21.464844 Z M 31.035156 26.945312 " fill-opacity="1" fill-rule="nonzero"/></g><g clip-path="url(#6584e6c491)"><path fill="#000000" d="M 12.835938 1.1875 C 6.398438 1.1875 1.1875 6.398438 1.1875 12.835938 C 1.1875 19.269531 6.398438 24.484375 12.835938 24.484375 C 19.269531 24.484375 24.484375 19.269531 24.484375 12.835938 C 24.484375 6.398438 19.269531 1.1875 12.835938 1.1875 Z M 12.835938 22.328125 C 7.589844 22.328125 3.339844 18.082031 3.339844 12.835938 C 3.339844 7.589844 7.589844 3.339844 12.835938 3.339844 C 18.082031 3.339844 22.332031 7.589844 22.332031 12.835938 C 22.332031 18.082031 18.082031 22.328125 12.835938 22.328125 Z M 12.835938 22.328125 " fill-opacity="1" fill-rule="nonzero"/></g><path fill="#000000" d="M 15.222656 18.601562 C 10.578125 18.601562 6.808594 14.832031 6.808594 10.183594 C 6.808594 10.0625 6.820312 9.941406 6.828125 9.816406 C 6.210938 10.808594 5.851562 11.976562 5.851562 13.226562 C 5.851562 16.820312 8.765625 19.734375 12.359375 19.734375 C 13.746094 19.734375 15.027344 19.296875 16.085938 18.558594 C 15.804688 18.589844 15.515625 18.601562 15.222656 18.601562 Z M 15.222656 18.601562 " fill-opacity="1" fill-rule="nonzero"/></svg>
    </label>
</form>


<div id="search-suggestions" class="search-suggestions"></div>
</div>