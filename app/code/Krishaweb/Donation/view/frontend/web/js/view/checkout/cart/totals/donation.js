define(
    [
        'Krishaweb_Donation/js/view/checkout/summary/donation'
    ],
    function (Component) {
        'use strict';
 
        return Component.extend({
            /**
             * @override
             * use to define amount is display setting
             */
            isDisplayed: function () {
                return true;
            }
        });
    }
);
