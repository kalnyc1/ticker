/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery --dev", then uncomment to require it.
var $ = require('jquery');
window.$ = $;

// Need jQuery-ui? Install it with "yarn add jquery-ui-dist --dev", then uncomment to require it.
require('jquery-ui');

// Import bootstrap JavaScript
import('bootstrap');

// Import chartist JavaScript
import Chartist from 'chartist';
window.Chartist = Chartist;

import TickerCommands from './ticker';
window.TickerCommands = TickerCommands;
