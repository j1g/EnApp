(function($) {
    "use strict";

    var $usernameField;

    $(document).ready(function() {
        bindSelectors();
        main();
    });

    function bindSelectors() {
        $usernameField = $("#username");
    }

    function main() {
        // username field is available
        if ($usernameField.length) {
            $usernameField.focus();
        }

    }
})(jQuery);