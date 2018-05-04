define(['jquery', 'uiComponent', 'ko'], function ($, Component, ko) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Krishaweb_Donation/block-donation'
            },
            initialize: function () {
                this._super();
            },
            setDonation: function () {

                var formData = $('#add-donation').serialize();
                $.ajax({
                    url: '/donation/index/setdonation',
                    data: formData,
                    type: 'post',
                    dataType: 'json',
                    showLoader: true ,//use for display loader 
                    success: function (res) {
                        debugger;
                        /*$('body').loader('hide');
                        var result = jQuery.parseJSON(res);
                        if(result.status == 'success'){
                            window.location.href = result.redirect_url;
                        }*/
                    }
                });
            },
        });
    }
);