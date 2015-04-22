/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require.config({
    paths: {
        suluactivity: '../../suluactivity/js'
    }
});

define(function() {

    'use strict';

    return {

        name: 'Sulu Activity Bundle',

        initialize: function(app) {
            app.components.addSource('suluactivity', '/bundles/suluactivity/js/components');
        }
    };
});
