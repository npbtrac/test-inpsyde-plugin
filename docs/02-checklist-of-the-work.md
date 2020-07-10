- When installed, the plugin has to make available a custom endpoint on the WordPress site. With “custom endpoint” we mean an arbitrary URL not recognized by WP as a standard URL, like a permalink or so.
  - After activating, custom endpoint available at
    - http://127.0.0.1:10180/?pagename=custom-inpsyde if pretty URL mode not turned on
    - http://127.0.0.1:10180/custom-inpsyde/ if pretty URL mode on
  - This custom endpoint set up with hook `init` before main WordPress parse request process fired to avoid extra actions on widgets ... https://codex.wordpress.org/Plugin_API/Action_Reference
  - If you want to use the theme, we can use hook `parse_query` (I use this hook for making the appearance completely work with theme)

- Add PHP Coding Standards (PHPCS)
  - At first, I intended to use WordPress rules but then I discover Inpsyde rules on GitHub https://github.com/inpsyde/php-coding-standards -> I use it (added .editorconfig for stuffs)
  - I use this for checking phpcs on commits https://github.com/bjornjohansen/wp-pre-commit-hook
